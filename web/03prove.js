
var amtInCart = document.getElementById('totalAmt');
var checkoutButton = document.getElementById('checkoutButton');
if(amtInCart.innerHTML > 200000){
    amtInCart.style.color = 'red';
    checkoutButton.innerHTML = 'Total cost has exceeded credit amount';
    checkoutButton.setAttribute('href','#');
}else {
    amtInCart.style.color = 'green';
    checkoutButton.innerHTML = 'Continue to Checkout';
    checkoutButton.style.backgroundColor = 'green';
    checkoutButton.style.color = 'white';

}
var date = new Date();
date.setDate(date.getDate() - 1);
document.getElementById('yesterday').innerHTML = date;
