$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$.validator.addMethod(
    "accept",
    function (value, element, param) {
        if (this.optional(element)) return true;

        var ext = value.split(".").pop().toLowerCase();
        var allowedExts = param.split("|");
        return allowedExts.includes(ext);
    },
    "Please upload a file with a valid extension."
);

$("#contactForm").validate({
    rules: {
        name: {
            required: true,
            maxlength: 255,
        },
        email: {
            required: true,
            email: true,
            maxlength: 255,
        },
        phone: {
            required: true,
            digits: true,
            minlength: 10,
            maxlength: 10,
        },
        gender: {
            required: true,
        },
        profile_image: {
            required: function () {
                return $("#contact_id").val() === "";
            },
            accept: "jpg|jpeg|png",
        },
        additional_file: {
            required: function () {
                return $("#contact_id").val() === "";
            },
            accept: "pdf|doc|docx|jpg|png|jpeg",
        },
    },
    messages: {
        name: "Please Enter Name",
        email: {
            required: "Please Enter Email",
            email: "Enter a valid email",
        },
        phone: {
            required: "Please Enter Phone No.",
            digits: "Only numbers allowed",
            minlength: "Phone must be at least 10 digits",
            maxlength: "Phone must not exceed 10 digits",
        },
        gender: "Please select gender",
        profile_image: {
            required: "Please Upload profile image",
            accept: "Only image files allowed (jpg, jpeg, png)",
        },
        additional_file: {
            required: "Please Upload Any Additional Document",
            accept: "Invalid file type",
        },
    },
    errorElement: "label",
    errorClass: "error",
    highlight: function (element) {
        $(element).addClass("error");
    },
    unhighlight: function (element) {
        $(element).removeClass("error");
    },

    errorPlacement: function (error, element) {
        if (element.attr("name") == "gender") {
            error.insertAfter("#genderWrapper");
        } else {
            error.insertAfter(element);
        }
    },

    submitHandler: function (form) {
        var id = $("#contact_id").val();
        var url = id ? "/contact/update/" + id : "/contact/store";

        let formData = new FormData(form);
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $("#contactForm")[0].reset();

                $("#profileImagePreview").html("");
                $("#additionalFilePreview").html("");

                const message =
                    data.value == 1
                        ? "Contact Saved successfully."
                        : "Contact Update successfully.";

                $("#successAlert").text(message);
                $("#alertContainer").fadeIn();

                setTimeout(function () {
                    $("#alertContainer").fadeOut();
                }, 5000);

                loadContacts();
            },
            error: function () {
                alert("Something went wrong.");
            },
        });
    },
});

$("#profile_image, #additional_file").on("change", function () {
    const input = $(this);
    input.valid();

    if (this.files.length > 0) {
        input.removeClass("error");
        input.next("label.error").remove();
    }
});

$(document).ready(function () {
    $("#customFieldForm").validate({
        rules: {
            field_name: {
                required: true,
                maxlength: 255,
            },
            field_type: {
                required: true,
            },
        },
        messages: {
            field_name: {
                required: "Please enter field name",
                maxlength: "Maximum 255 characters allowed",
            },
            field_type: {
                required: "Please select a field type",
            },
        },
        errorElement: "label",
        errorClass: "error text-danger",
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    });
});

setTimeout(function () {
    const alert = document.getElementById("successMessage");
    if (alert) {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    }
}, 5000);

function loadContacts() {
    $.get(
        "/contacts/list",
        {
            name: $("#search_name").val(),
            email: $("#search_email").val(),
            gender: $("#filter_gender").val(),
        },
        (res) => $("#contactResults").html(res)
    );
}

$("#search_name, #search_email, #filter_gender").on(
    "input change",
    loadContacts
);

loadContacts();

$(document).on("click", ".editBtn", function () {
    var id = $(this).data("id");
    $.get("/contact/edit/" + id, function (r) {
        $("#contact_id").val(r.contact.id);
        $("#name").val(r.contact.name);
        $("#email").val(r.contact.email);
        $("#phone").val(r.contact.phone);
        $("input[name=gender][value=" + r.contact.gender + "]").prop(
            "checked",
            true
        );
        $.each(r.contact.custom_values || [], function (_, cv) {
            $('*[name="custom[' + cv.custom_field_id + ']"]').val(cv.value);
        });

        if (r.contact.profile_image) {
            $("#profileImagePreview").html(
                `<img src="/${r.contact.profile_image}" alt="Profile Image" width="120" class="img-thumbnail">`
            );
        } else {
            $("#profileImagePreview").html("");
        }

        if (r.contact.additional_file) {
            const filePath = `/${r.contact.additional_file}`;
            const extension = r.contact.additional_file
                .split(".")
                .pop()
                .toLowerCase();

            if (
                ["jpg", "jpeg", "png", "gif", "bmp", "webp"].includes(extension)
            ) {
                $("#additionalFilePreview").html(
                    `<img src="${filePath}" alt="Additional File" width="120" class="img-thumbnail">`
                );
            } else {
                $("#additionalFilePreview").html(
                    `<a href="${filePath}" target="_blank" class="btn btn-sm btn-outline-primary">View File</a>`
                );
            }
        } else {
            $("#additionalFilePreview").html("");
        }
    });
});

$(document).on("click", ".delBtn", function () {
    if (!confirm("Are You Sure Delete Contact?")) return;
    var id = $(this).data("id");
    $.ajax({
        url: "/contact/delete/" + id,
        type: "DELETE",
        success: function () {
            loadContacts();
            $("#successAlert").text(res.message);
            $("#alertContainer").fadeIn();

            setTimeout(function () {
                $("#alertContainer").fadeOut();
            }, 5000);
        },
        error: function () {
            alert("Failed to delete contact.");
        },
    });
});
