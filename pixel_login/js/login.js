$(document).ready(function () {
    $("#form").submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        // Regex patterns
        const namePattern = /^[A-Za-z\s]+$/;
        const emailPattern = /^[\w.]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/;
        const phonePattern = /^\d{10}$/;
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/;

        let isValid = true;

        // Get form fields
        const name = $("input[name='name']").val();
        const password = $("input[name='password']").val();
        const email = $("input[name='email']").val();
        const phone = $("input[name='phone']").val();
        const address = $("input[name='address']").val();

        // Validate Name
        if (!namePattern.test(name)) {
            alert("Invalid name! Only alphabets and spaces allowed.");
            isValid = false;
        }

        // Validate Password
        if (!passwordPattern.test(password)) {
            alert("Invalid password! Must contain at least 12 characters, one uppercase, one lowercase, one digit, and one special character.");
            isValid = false;
        }

        // Validate Email
        if (!emailPattern.test(email)) {
            alert("Invalid email format!");
            isValid = false;
        }

        // Validate Phone
        if (!phonePattern.test(phone)) {
            alert("Invalid phone number! Must be 10 digits.");
            isValid = false;
        }

        // Validate Address
        if ($.trim(address) === "") {
            alert("Address cannot be empty!");
            isValid = false;
        }

        if (isValid) {
            // AJAX Request
            $.ajax({
                url: "process.php",
                type: "POST",
                data: $("#form").serialize(),
                success: function (response) {
                    alert("Login successful!");
                    window.location.href = "upload_page.php";
                    $("#form")[0].reset();
                },
                error: function () {
                    alert("Login failed!");
                }
            });
        }
    });
});
