<script>
    // if(!localStorage.getItem('userId')){
    //     let randomNum = Math.ceil(Math.random() * 1000 + 1)
    //     localStorage.setItem('userId', `user${randomNum}`);
    // }
    
    let addCartClass = document.querySelectorAll(".addCart");
    let cartMessage = document.querySelector('#cartMessage');
    let cartAlert = document.querySelector('#cartAlert');
    let cartQuantity = document.querySelector('#cart-qty')


    for(let i = 0; i < addCartClass.length; i++){
        addCartClass[i].addEventListener('submit', function(e){
            e.preventDefault();
            let slugValue = addCartClass[i]['productSlug'].value;
            let slug = {
                'slug': slugValue,
                'quantity': 1
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
    }
    
</script>

