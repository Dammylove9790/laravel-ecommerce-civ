<script>

    let sizeForm = document.forms["add_size"];
    let size_error = document.querySelector("#size_error");
    
    function validateSize(cat) {
        cat = cat.value.trim();
        if (cat === "") {
            size_error.innerHTML = "The size field is required.";
        } else if (typeof cat !== "string") {
            size_error.innerHTML =
                "The size must be a string.";
        } else if (cat.length > 25) {
            size_error.innerHTML = "The size must not be greater than 25 characters.";
        } else {
            size_error.innerHTML = "";
        }
    }
    
    function backendVer(){
        let formData = new FormData(sizeForm);
    
        axios.post("{{route('users.admin.size.store')}}", formData)
        .then(function (response) {
            console.log(response.data);
            let data = response.data;
            if(data){         
                if(data.success){
                    size_error.classList.add('text-success');
                    size_error.classList.remove('text-danger');
    
                    size_error.innerHTML = "Product Size uploaded successfully."
                    setTimeout(() => {
                        window.location.assign("{{route('users.admin.size')}}");
                    }, 1000);
                }
            }
        })
        .catch(function (error) {
            console.log(error);
            if (error.response) {
                if(error.response.data.errors){
                    let response_error = error.response.data.errors;      
                    if (response_error.size) {
                        size_error.classList.remove('text-success');
                        size_error.classList.add('text-danger');
                        size_error.innerHTML = response_error.size[0];
                    }
                }
            }
        });
    }
    
    sizeForm.onsubmit = (e) => {
        e.preventDefault();
        validateSize(sizeForm["size"]);
        backendVer();
    };
    </script>