<script>

let categoryForm = document.forms["add_category"];
let category_error = document.querySelector("#category_error");

function validateCategory(cat) {
    cat = cat.value.trim();
    if (cat === "") {
        category_error.innerHTML = "The category field is required.";
    } else if (typeof cat !== "string") {
        category_error.innerHTML =
            "The category must be a string.";
    } else if (cat.length > 25) {
        category_error.innerHTML = "The category must not be greater than 25 characters.";
    } else {
        category_error.innerHTML = "";
    }
}

function backendVer(){
    let formData = new FormData(categoryForm);

    axios.post("{{route('users.admin.products.category.store')}}", formData)
    .then(function (response) {
        console.log(response.data);
        let data = response.data;
        if(data){         
            if(data.success){
                category_error.classList.add('text-success');
                category_error.classList.remove('text-danger');

                category_error.innerHTML = "Product Category uploaded successfully."
                setTimeout(() => {
                    window.location.assign("{{route('users.admin.products.category')}}");
                }, 2000);
            }
        }
    })
    .catch(function (error) {
        console.log(error);
        if (error.response) {
            if(error.response.data.errors){
                let response_error = error.response.data.errors;      
                if (response_error.category) {
                    category_error.classList.remove('text-success');
                    category_error.classList.add('text-danger');
                    category_error.innerHTML = response_error.category[0];
                }
            }
        }
    });
}

categoryForm.onsubmit = (e) => {
    e.preventDefault();
    validateCategory(categoryForm["category"]);
    backendVer();
};
</script>