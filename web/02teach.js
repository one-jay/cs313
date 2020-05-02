document.querySelector("#btn1").
addEventListener("click", ()=> alert('Clicked!'))

var div1 = document.querySelector('#div1')
var colorSelect = document.querySelector('#divcolor')
colorSelect.addEventListener("change", 
()=> {
    colorSelect.val = colorSelect.value
    div1.style.backgroundColor = colorSelect.val
})

$('#divcolor2').change(function(){
    $('#div4').css({backgroundColor: $('#divcolor2').val()})
})

$('#hide').click(function(){
    $('#div3').fadeToggle(1000)
})