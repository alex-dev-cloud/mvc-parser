window.onload = () => {
    let $preloader = document.querySelector('.preloader-overlay');

    $preloader.addEventListener('transitionend', function () {
        this.classList.add('hide');
    })

    let referrerHost = document.referrer.split('/')[2];
    let currentHost = location.host;

    if (referrerHost == currentHost) {
        $preloader.classList.add('done');
    }

    setTimeout( () => {
        $preloader.classList.add('done')
    }, 1000)
}
