<script>
    let input = document.querySelector("#input");
    let itemPrice = parseInt(document.querySelector("#itemPrice").innerHTML);
    let itemTotalPrice = document.querySelector('#itemTotalPrice');
    let addCartBtn = document.querySelector('#addCartBtn');
    let buyBtn = document.querySelector('#buyBtn');
    let availableQty = parseInt(document.querySelector('#availableQty').innerHTML);

    input.previousElementSibling.disabled = true;

    if(availableQty < 1){
        input.style.border = "1px solid red";
        addCartBtn.disabled = true;
        buyBtn.disabled = true;
    }
      

    let cartMessage = document.querySelector('#cartMessage');
    let cartAlert = document.querySelector('#cartAlert');
    let cartQuantity = document.querySelector('#cart-qty');

    addCartBtn.addEventListener('click', function(e){
            e.preventDefault();
            let slug = {
                'slug': '{{$product->slug}}',
                'quantity': input.value
                // 'userId': localStorage.getItem('userId')
            }
            axios.post("{{route('cart.add')}}", slug)
            .then(function (response) {
                let data = response.data;
                console.log(data);

                cartAlert.style.display = "block";
                if(data.productExist){
                    cartMessage.innerHTML = "Product is already present in the cart!"
                    cartAlert.classList.remove("bg-sucess");
                    cartAlert.classList.add("bg-warning");
                }
                else{
                    cartMessage.innerHTML = "Product added to cart successfully!";
                    cartAlert.classList.remove("bg-warning");
                    cartAlert.classList.add("bg-success");
                    cartQuantity.innerHTML = data.cartQty; 
                }
                setTimeout(()=>{
                    cartAlert.style.display = "none";
                }, 3000)
            })
            .catch(function (error) {
                console.log(error)
            });
        })

    function increaseQty(){
        input.value = parseInt(input.value) + 1;
        let inputValue = input.value;

        if (inputValue >= 1){
            input.style.border = "none";
        }
        if (inputValue > 1){
            input.previousElementSibling.disabled = false;
        }

        if(inputValue <= availableQty){
            // updateCart(input.nextElementSibling.nextElementSibling.value, input.value);
            computeTotalPrice();
            input.style.border = "none";
            addCartBtn.disabled = false;
            buyBtn.disabled = false;

        }
        else{
            input.style.border = "1px solid red";
            addCartBtn.disabled = true;
            buyBtn.disabled = true;
        }
    }

    function decreaseQty(){
        input.value = parseInt(input.value) - 1;
        let inputValue = input.value;

        if (inputValue == 1){
            input.previousElementSibling.disabled = true;
        }
        if (inputValue > 1){
            input.previousElementSibling.disabled = false;
        }

        if(inputValue <= availableQty){
            // updateCart(input.nextElementSibling.nextElementSibling.value, input.value);
            computeTotalPrice();
            input.style.border = "none";
            addCartBtn.disabled = false;
            buyBtn.disabled = false;

        }
        else{
            input.style.border = "1px solid red";
            addCartBtn.disabled = true;
            buyBtn.disabled = true;
        }
    }

    function changeQty(){
        let inputValue = Number(input.value);
        // alert(elem)

        if(!isNaN(inputValue) && Number.isInteger(inputValue) && inputValue > 0 ){
            // console.log("integer");

            // check if the input is not more than the available quantity
            if(inputValue <= availableQty){
                input.previousElementSibling.disabled = false;
                input.style.border = "none";
                // updateCart(elem.nextElementSibling.nextElementSibling.value, num);
                computeTotalPrice();
                addCartBtn.disabled = false;
                buyBtn.disabled = false;

            }
            else{
                input.style.border = "1px solid red";
                addCartBtn.disabled = true;
                buyBtn.disabled = true;

            }
        }
        else{
            // console.log('not integer');
            input.previousElementSibling.disabled = true;
            input.style.border = "1px solid red";
            addCartBtn.disabled = true;
            buyBtn.disabled = true;

        }
    }


    function computeTotalPrice(){
        let total = input.value * itemPrice
        itemTotalPrice.innerHTML = total.toLocaleString();
    }

    

</script>