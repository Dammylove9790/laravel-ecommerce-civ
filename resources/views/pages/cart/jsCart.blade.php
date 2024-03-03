<script>
    let clearCartVar = document.getElementById("clearCart");
    let cartTotalPrice = document.querySelector('#cartTotalPrice');
    let checkout = document.querySelector("#checkout");
    let checkout_btn = document.querySelector('#checkout_btn');
    
    checkout_btn.addEventListener('click', ()=>{
        window.location.assign("{{route('order.review')}}");
    })

    let inputs = document.querySelectorAll('.inputs');
    let availableQty = document.querySelectorAll('.availableQty');

    for(let i = 0; i < inputs.length; i++){
        if (parseInt(inputs[i].value) === 1){
            inputs[i].previousElementSibling.disabled = true;
        }
    }

    function updateCart(slugValue, qty){
        let slug = {
            'slug': slugValue,
            'quantity': qty
        }

        axios.post("{{route('cart.update')}}", slug)
            .then(function (response) {
                let data = response.data;
                console.log(data);
            })
            .catch(function (error) {
                console.log(error)
            });
    }

    function computeItemPrice(elem, input){
        let itemPrice = elem.parentNode.nextElementSibling.lastElementChild;
        let itemTotalPrice = elem.parentNode.nextElementSibling.nextElementSibling.lastElementChild;

        itemTotalPrice.innerHTML = itemPrice.innerHTML * input;

    }

        // function to check if any of the input is less than 1 
    // or greater than available quantity and disable checkout
    function checkInputs(){
        let inputValues = [];
        let availableQtyValues = [];

        for (let inputValue = 0; inputValue < inputs.length; inputValue++){
            inputValues.push(parseInt(inputs[inputValue].value));
            availableQtyValues.push(parseInt(availableQty[inputValue].value));
        }

        // console.log(inputValues);
        // console.log(availableQtyValues);

        let checkoutBoolean = inputValues.some((value, key)=>{
           return (isNaN(value) || !Number.isInteger(value) || value < 1 || value > availableQtyValues[key]);
        });
        // console.log(checkoutBoolean);
        if(checkoutBoolean){
            // checkout['checkout_btn is the submit button in checkout form']
            checkout_btn.disabled = true;
        }
        else{
            checkout_btn.disabled = false;
        }
    }

    checkInputs();


    function increaseQty(elem){
        let input = elem.previousElementSibling;
        input.value = parseInt(input.value) + 1;

        if (parseInt(input.value) >= 1){
            input.style.border = "none";
        }
        if (parseInt(input.value) > 1){
            input.previousElementSibling.disabled = false;
        }

        if(input.value <= parseInt(elem.parentNode.previousElementSibling.value)){
            updateCart(input.nextElementSibling.nextElementSibling.value, input.value);
            computeItemPrice(elem, input.value);
            computeTotalPrice();
            input.style.border = "none";
        }
        else{
            input.style.border = "1px solid red";
        }
        checkInputs();
    }

    function decreaseQty(elem){
        let input = elem.nextElementSibling;
        input.value = parseInt(input.value) - 1;

        if (parseInt(input.value) === 1){
            elem.disabled = true;
        }
        if (parseInt(input.value) > 1){
            elem.disabled = false;
        }

        if(input.value <= parseInt(elem.parentNode.previousElementSibling.value)){
            updateCart(input.nextElementSibling.nextElementSibling.value, input.value);
            computeItemPrice(elem, input.value);
            computeTotalPrice();
            input.style.border = "none";
        }
        else{
            input.style.border = "1px solid red";
            checkout_btn.disabled = true;
        }
        checkInputs();
    }

    function changeQty(elem){
        checkInputs();
        num = Number(elem.value);
        // alert(elem)

        if(!isNaN(num) && Number.isInteger(num) && num > 0 ){
            // console.log("integer");

            // check if the input is not more than the available quantity
            if(num <= parseInt(elem.parentNode.previousElementSibling.value)){
                elem.previousElementSibling.disabled = false;
                elem.style.border = "none";
                updateCart(elem.nextElementSibling.nextElementSibling.value, num);
                computeItemPrice(elem, num);
                computeTotalPrice();
            }
            else{
                elem.style.border = "1px solid red";
            }

        }
        else{
            // console.log('not integer');
            elem.previousElementSibling.disabled = true;
            elem.style.border = "1px solid red";
        }
    }

    let totalCartPriceClass = document.querySelectorAll('.totalPrice');

    function computeTotalPrice(){
        let totalCartPrice = 0;
        if(totalCartPriceClass.length > 0){
            for(let j = 0; j < totalCartPriceClass.length; j++){
                totalCartPrice += parseInt(totalCartPriceClass[j].innerHTML);
            }
            cartTotalPrice.innerHTML = totalCartPrice.toLocaleString();
        }
    }
    computeTotalPrice();

    function removeItem(elem){
        slug = {
            'slug': elem.value
        };
        axios.post("{{route('cart.delete')}}", slug)
        .then(function(response){
            console.log(response.data);
            if(response.data){
                if(response.data.total === 0){
                    clearCartVar.nextElementSibling.style.display = "none";
                    clearCartVar.style.display = "none";
                }
                cartTotalPrice.innerHTML = response.data.total;
                document.querySelector('#cart-qty').innerHTML = response.data.cartQty;
            }
        })
        .catch(function(error){
            console.log(error);
        })
        elem.parentNode.remove();
    }

    function clearCart(){
        axios.post("{{route('cart.clear')}}")
        .then(function(response){
            console.log(response.data);
            document.querySelector('#cart-qty').innerHTML = 0;
        })
        .catch(function(error){
            console.log(error);
        })
        document.querySelector('#allCartItems').remove();
        clearCartVar.remove();
        checkout.remove();
    }

</script>