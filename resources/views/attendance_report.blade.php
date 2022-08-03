<!DOCTYPE html>
<html lang="en">
<head>
  <title>Attendance Report</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    .table-border{
        border: 1px solid rgb(59, 127, 134);
    }
    .th-bg{
        background: rgb(59, 127, 134);
        color:#fff;
    }
    .title{
        color:rgb(59, 127, 134);

    }
  </style>
</head>
<body>  
   <div class="" >
                <h3 class="text-center mb-4 title ">Attendance Report</h3>
                <table>                   
                    <tbody>
                      <tr>
                        <td > <p class="mr-5"><strong>Department Name :</strong> {{ $report->department_name }}</p></td>
                        <td><p><strong>Batch :</strong> {{ $report->batch->batch_name }}</p></td>                        
                      </tr>
                      <tr>
                        <td><p><strong>Course Name :</strong> {{ $report->course_name }} </p></td>
                        <td><p><strong>Course Code :</strong> {{ $report->course_code }}</p></td>                        
                      </tr>
                      <tr>
                        <td><p><strong>Date :</strong> {{ $report->date }}</p></td>
                        <td><p><strong>Total Attendance :</strong> {{ $report->report->count() }}</p></td>                     
                      </tr>                   
                    </tbody>
                  </table>          
              
            </div>        
  <table class="table table-striped">
    <thead>
      <tr class="th-bg">
        <th>Sl</th>
        <th> Name</th>
        <th> Roll</th>
        <th>Student Id</th>
        <th>Comments</th>
       
      </tr>
    </thead>
    <tbody>
        @foreach (  $report->report as $key => $report  )         
      <tr class="table-border text-center">        
        <td>{{$key+1}}</td>
        <td>{{$report->student->student_name}}</td>
        <td>{{$report->student->roll_no}}</td>
        <td>{{$report->student_id}}</td>
        @if($report->comments != null)         
        <td>{{$report->comments}}</td>        
        @else
      <td> N/C</td>        
       @endif        
      </tr>
      @endforeach
      
    </tbody>
  </table>


</body>
</html>