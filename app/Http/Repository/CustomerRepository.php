<?php

namespace App\Http\Repository;


use App\Models\Customer;
use App\Traits\ImageUpload;


class CustomerRepository
{
    use ImageUpload;

    public function getCustomer(){
        $result = Customer::select("id","name","previous_due")->orderBy('id','desc')->get();
        return response()->json($result);
    }

    public function storeCustomer($request)
    {
        if ($request->hasfile('image')) {
            $image = $this->imageUpload($request, 'customer');
        }
        $validatedData = $request->validated();
        $validatedData['created_by'] = auth()->user()->id;
        $validatedData['image'] = $image ?? null;
        Customer::insert($validatedData);

        return response()->json(['message' => 'Customer Added Successfully'], 201);
    }
    public function editCustomer($id)
    {
        $result = Customer::findOrFail($id);
        return response()->json($result);
    }
    public function updateCustomer($request, $id)
    {

        $customer = Customer::findOrFail($id);
        if ($request->hasFile('image')) {

            $image = $this->imageUpload($request, 'customer');
        } else {
            $image = $customer->image;
        }
        $validatedData = $request->validated();
        $validatedData['updated_by'] = auth()->user()->id;
        $validatedData['image'] = $image;
        $customer->update($validatedData);
        return response()->json(['message' => 'Customer Updated Successfully'], 201);
    }
    public function GetCustomerBySearch($request)
    {
        $type = $request->type;
        $item = $request->item;
        $list = $request->list;
        $search = $request->search;

        $query = Customer::with('category')
            ->when($type == 'category', function ($q) use ($item) {
                $q->where('category_id', '=', $item);
            })
            ->when($type == 'global', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate($list);

        $query->transform(function ($customer) {
            return [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'category' => $customer->category->name,
                'image' => $customer->image,
            ];
        });

        return $query;
    }
    public function deleteCustomer($id)
    {
        Customer::findOrFail($id)->delete();
        return response()->json(['message' => 'Customer Delete Successfully'], 201);
    }
}
