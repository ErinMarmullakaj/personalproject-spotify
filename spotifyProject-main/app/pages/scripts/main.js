let options = ['monthly','yearly'];
let spans = document.querySelectorAll('.payment');
let payment_status = document.querySelector('meta[name="payment_done"]').getAttribute('content');

spans.forEach((s,index)=>{
    s.onclick = function(){
        if(payment_status != 'Done'){
            localStorage.setItem('option-choosed',options[index]);
            window.location.href = `payment.php`;
        }else{
            alert('You Alredy Payed!');
        }
    }
});


if(document.referrer.split('/').at(-1) == 'payment.php'){
    setTimeout(()=>{
        location.reload();
        document.referrer = '';
    },2000);
}


function changeState(){
    document.querySelector('.search-bar').onclick = function(){
        document.querySelector('.search-results').style.display = 'block';
    
        document.querySelector('.search-bar').onclick = function(){
            document.querySelector('.search-results').style.display = 'none';
            changeState();
        }
    }
}

changeState();

    // if(document.querySelector('.search-results').style.display == 'none'){
    //     document.querySelector('.search-results').style.display = 'block';
    // }else{
    //     document.querySelector('.search-results').style.display = 'none';
    // }
