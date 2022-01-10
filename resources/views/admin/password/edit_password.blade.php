@extends('admin.admin_master');

@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="row" style="padding: 20px;">
    <div class="col-md-6">
        <h3>Change Password</h3>

        <form method="post" action="{{ route('admin.password.update') }}">
            @csrf

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Current Password</label>
                <input id="current_password" type="password" name="oldpassword" class="form-control">
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">New Password</label>
                <input id="password" type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div> {{-- End Col Md 6 --}}
</div> {{-- End Row --}}

<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload =function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>
@endsection
