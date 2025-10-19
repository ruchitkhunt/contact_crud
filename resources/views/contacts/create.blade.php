<div id="alertContainer" style="display:none;">
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
        Contact saved successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
<div id="loader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
     background:rgba(255,255,255,0.7); z-index:9999; text-align:center; padding-top:20%;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>


<form id="contactForm" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <input type="hidden" name="id" id="contact_id">

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="">
            </div>

            <div class="form-group pt-3">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" name="phone" id="phone" value="">
            </div>

            <div class="form-group pt-3">
                <label for="additionalfile">Additional File</label>
                <input type="file" class="form-control" name="additional_file" id="additional_file">
                <div id="additionalFilePreview" class="pt-2">
                </div>
            </div>

        </div>

        <div class="col-md-6">

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="">
            </div>

            <div class="form-group pt-3">
                <label for="profileimage">Profile Image</label>
                <input type="file" class="form-control" name="profile_image" id="profile_image">
                <div id="profileImagePreview" class="pt-2">
                </div>
            </div>

            <div class="form-group pt-5">
                <label for="gender">Gender:</label>
                <label><input type="radio" name="gender" value="Male"> Male</label>
                <label><input type="radio" name="gender" value="Female"> Female</label>
                <span id="genderWrapper"></span>

            </div>


        </div>

        @foreach($custom_fields as $field)
        <div class="col-md-6 pt-3">
            <div class="form-group">
                <label>{{ $field->field_name }}</label>
                @if($field->field_type=='text')
                <input type="text" name="custom[{{ $field->id }}]" class="form-control">
                @elseif($field->field_type=='textarea')
                <textarea name="custom[{{ $field->id }}]" class="form-control"></textarea>
                @elseif($field->field_type=='date')
                <input type="date" name="custom[{{ $field->id }}]" class="form-control">
                @endif
            </div>
        </div>
        @endforeach

    </div>
    <div class="pt-5">
        <input type="submit" class="btn btn-success" value="Submit">
    </div>
</form>