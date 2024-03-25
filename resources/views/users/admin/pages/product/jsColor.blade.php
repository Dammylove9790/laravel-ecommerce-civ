<script>

    let colorForm = document.forms["add_color"];
    let color_error = document.querySelector("#color_error");
    
    function validateColor(cat) {
        cat = cat.value.trim();
        if (cat === "") {
            color_error.innerHTML = "The color field is required.";
        } else if (typeof cat !== "string") {
            color_error.innerHTML =
                "The color must be a string.";
        } else if (cat.length > 25) {
            color_error.innerHTML = "The color must not be greater than 25 characters.";
        } else {
            color_error.innerHTML = "";
        }
    }
    
    function backendVer(){
        let formData = new FormData(colorForm);
    
        axios.post("{{route('users.admin.color.store')}}", formData)
        .then(function (response) {
            console.log(response.data);
            let data = response.data;
            if(data){         
                if(data.success){
                    color_error.classList.add('text-success');
                    color_error.classList.remove('text-danger');
    
                    color_error.innerHTML = "Product Color uploaded successfully."
                    setTimeout(() => {
                        window.location.assign("{{route('users.admin.color')}}");
                    }, 1000);
                }
            }
        })
        .catch(function (error) {
            console.log(error);
            if (error.response) {
                if(error.response.data.errors){
                    let response_error = error.response.data.errors;      
                    if (response_error.color) {
                        color_error.classList.remove('text-success');
                        color_error.classList.add('text-danger');
                        color_error.innerHTML = response_error.color[0];
                    }
                }
            }
        });
    }
    
    colorForm.onsubmit = (e) => {
        e.preventDefault();
        validateColor(colorForm["color"]);
        backendVer();
    };
    </script>