<script>

let editProductForm = document.forms["editProductForm"];
let name = editProductForm["productName"];
let category = editProductForm["productCategory"];
let price = editProductForm["productPrice"];
let quantity = editProductForm["productQuantity"];
let measurement = editProductForm["productMeasurement"];
let description = editProductForm["productDescription"];
let address = editProductForm["productAddress"];
let state = editProductForm["productState"];
let city = editProductForm["productCity"];
let frontView = editProductForm["productFrontView"];
let backView = editProductForm["productBackView"];
let leftView = editProductForm["productLeftView"];
let rightView = editProductForm["productRightView"];

let validity = document.querySelector("#validity");

let errors = {};
let nameError = document.querySelector("#productNameErr");
let categoryError = document.querySelector("#productCategoryErr");
let priceError = document.querySelector("#productPriceErr");
let quantityError = document.querySelector("#productQuantityErr");
let measurementError = document.querySelector("#productMeasurementErr");
let descriptionError = document.querySelector("#productDescriptionErr");
let addressError = document.querySelector("#productAddressErr");
let stateError = document.querySelector("#productStateErr");
let cityError = document.querySelector("#productCityErr");
let frontViewError = document.querySelector("#productFrontViewErr");
let backViewError = document.querySelector("#productBackViewErr");
let leftViewError = document.querySelector("#productLeftViewErr");
let rightViewError = document.querySelector("#productRightViewErr");

function validateName(name) {
    name = name.value.trim();
    if (name === "") {
        errors.name = "The product name field is required.";
    } else if (typeof name !== "string") {
        errors.name = "The product name must be a string.";
    } else if (name.length > 50) {
        errors.name = "The product name must not be greater than 50 characters.";
    } else {
        errors.name = "";
    }
    nameError.innerHTML = errors.name;
}

function validateCategory(cat) {
    cat = cat.value.trim();
    if (cat === "") {
        errors.category = "The product category field is required.";
    } else if (typeof cat !== "string") {
        errors.category = "The product category must be a string.";
    } else if (name.length > 25) {
        errors.category = "The product category must not be greater than 25 characters.";
    } else {
        errors.category = "";
    }
    categoryError.innerHTML = errors.category;
}

function validatePrice(price) {
    price = price.value.trim();
    if (price === "") {
        errors.price = "The product price field is required.";
    } else if (isNaN(price) && !Number.isInteger(price)) {
        errors.price = "The product price must be an integer.";
    } else if (price <= 0) {
        errors.price = "The product price must be greater than 0.";
    } else {
        errors.price = "";
    }
    priceError.innerHTML = errors.price;
}

function validateQuantity(qty) {
    qty = qty.value.trim();
    if (qty === "") {
        errors.quantity = "The product quantity field is required.";
    } else if (isNaN(qty) && !Number.isInteger(qty)) {
        errors.quantity = "The product quantity must be an integer.";
    } else if (qty < 1) {
        errors.quantity = "The product quantity must be greater than 0.";
    } else {
        errors.quantity = "";
    }
    quantityError.innerHTML = errors.quantity;
}

function validateMeasurement(meas) {
    meas = meas.value.trim();
    if (meas === "") {
        errors.measurement = "The product measurement field is required.";
    } else if (typeof meas !== "string") {
        errors.measurement =
            "The product measurement must be a string.";
    } else if (meas.length > 50) {
        errors.measurement = "The product measurement must not be greater than 25 characters.";
    } else {
        errors.measurement = "";
    }
    measurementError.innerHTML = errors.measurement;
}

function validateDescription(des) {
    des = des.value.trim();
    if (des === "") {
        errors.description = "The product description field is required.";
    } else if (typeof des !== "string") {
        errors.description =
            "The product description must be a string.";
    } else if (des.split(" ").length > 1000) {
        errors.description = "Description cannot be greater than 1000 words";
    } else {
        errors.description = "";
    }
    descriptionError.innerHTML = errors.description;
}

function validateAddress(addr) {
    addr = addr.value.trim();
    if (addr === "") {
        errors.address = "The product address field is required.";
    } else if (typeof addr !== "string") {
        errors.address =
            "The product address must be a string.";
    } else {
        errors.address = "";
    }
    addressError.innerHTML = errors.address;
}

function validateState(state) {
    state = state.value.trim();
    if (state === "") {
        errors.state = "The product state field is required.";
    } else if (typeof state !== "string") {
        errors.state =
            "The product state must be a string.";
    } else {
        errors.state = "";
    }
    stateError.innerHTML = errors.state;
}

function validateCity(city) {
    city = city.value.trim();
    if (city === "") {
        errors.city = "The product city field is required.";
    } else if (typeof city !== "string") {
        errors.city =
            "The product city must be a string.";
    } else {
        errors.city = "";
    }
    cityError.innerHTML = errors.city;
}


function validateFrontView(img) {
    img = img.value.trim();
    let allowedExt = ["jpg", "jpeg", "png"];
    let splitImageArray = img.split(".");
    if (img === "") {
        errors.frontView = "";
    } else if (
        !allowedExt.includes(splitImageArray[splitImageArray.length - 1])
    ) {
        errors.frontView = "The product front view must be an image.";
    } else {
        errors.frontView = "";
    }
    frontViewError.innerHTML = errors.frontView;
}

function validateBackView(img) {
    img = img.value.trim();
    let allowedExt = ["jpg", "jpeg", "png"];
    let splitImageArray = img.split(".");
    if (img === "") {
        errors.backView = "";
    } else if (
        !allowedExt.includes(splitImageArray[splitImageArray.length - 1])
    ) {
        errors.backView = "The product back view must be an image.";
    } else {
        errors.backView = "";
    }
    backViewError.innerHTML = errors.backView;
}

function validateLeftView(img) {
    img = img.value.trim();
    let allowedExt = ["jpg", "jpeg", "png"];
    let splitImageArray = img.split(".");
    if (img === "") {
        errors.leftView = "";
    } else if (
        !allowedExt.includes(splitImageArray[splitImageArray.length - 1])
    ) {
        errors.leftView = "The product left view must be an image.";
    } else {
        errors.leftView = "";
    }
    leftViewError.innerHTML = errors.leftView;
}

function validateRightView(img) {
    img = img.value.trim();
    let allowedExt = ["jpg", "jpeg", "png"];
    let splitImageArray = img.split(".");
    if (img === "") {
        errors.rightView = "";
    } else if (
        !allowedExt.includes(splitImageArray[splitImageArray.length - 1])
    ) {
        errors.rightView = "The product right view must be an image.";
    } else {
        errors.rightView = "";
    }
    rightViewError.innerHTML = errors.rightView;
}


function validateProduct() {
    validateName(name);
    validateCategory(category);
    validatePrice(price);
    validateQuantity(quantity);
    validateMeasurement(measurement);
    validateDescription(description);
    validateAddress(address);
    validateState(state);
    validateCity(city);
    validateFrontView(frontView);
    validateBackView(backView);
    validateLeftView(leftView);
    validateRightView(rightView);


    let formData = new FormData(editProductForm);

    axios.post("{{route('users.farmer.products.update', $product->slug)}}", formData)
    .then(function (response) {
        console.log(response.data);
        let data = response.data;
        if(data){
            let customErrors = data[0];
            if(customErrors){
                validity.classList.add("alert-danger");
                validity.classList.remove("alert-success");
                validity.innerHTML = '<button type="button" class="text-white close" data-dismiss="alert">&times;</button>Errors(s)! Kindly check your field(s) and try again';
            
                if (customErrors.productName) {
                    nameError.innerHTML = customErrors.productName;
                }
                if (customErrors.category) {
                    categoryError.innerHTML = customErrors.category;
                }
            }
            
            if(data.updateSuccess){
                validity.classList.add("alert-success");
                validity.classList.remove("alert-danger");
                validity.innerHTML = '<button type="button" class="text-white close" data-dismiss="alert">&times;</button>Your Product has been updated succesfully. You will be redirected to your product dashboard soon...';
                setTimeout(() => {
                    window.location.assign("{{route('users.farmer.products')}}");
                }, 2000);
            }
        }
    })
    .catch(function (error) {
        if (error.response) {
            console.log(error)
            if(error.response.data.errors){
                let errors = error.response.data.errors;
                console.log(errors);
                validity.classList.add("alert-danger");
                validity.classList.remove("alert-success");
                validity.innerHTML = '<button type="button" class="text-white close" data-dismiss="alert">&times;</button>Errors(s)! Kindly check your field(s) and try again';
            
                if (errors.productName) {
                    nameError.innerHTML = errors.productName[0];
                }
                if (errors.productCategory) {
                    categoryError.innerHTML = errors.productCategory[0];
                }
                if (errors.productPrice) {
                    priceError.innerHTML = errors.productPrice[0];
                }
                if (errors.productQuantity) {
                    quantityError.innerHTML = errors.productQuantity[0];
                }
                if (errors.productMeasurement) {
                    measurementError.innerHTML = errors.productMeasurement[0];
                }
                if (errors.productDescription) {
                    descriptionError.innerHTML = errors.productDescription[0];
                }
                if (errors.productFrontView) {
                    frontViewError.innerHTML = errors.productFrontView[0];
                }
                if (errors.productBackView) {
                    backViewError.innerHTML = errors.productBackView[0];
                }
                if (errors.productLeftView) {
                    leftViewError.innerHTML = errors.productLeftView[0];
                }
                if (errors.productRightView) {
                    rightViewError.innerHTML = errors.productRightView[0];
                }
            }
        }
    });
}

editProductForm.onsubmit = (e) => {
    e.preventDefault();
    validity.classList.add('alert')
    validateProduct();  
};

</script>