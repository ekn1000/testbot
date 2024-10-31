// https://codepen.io/LCweb/pen/YZGVRg?editors=0010


function touchScroll ($bind = '') {
    const slider = document.querySelector($bind);
    let isDown = false;
    let startX;
    let scrollLeft;

    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        slider.classList.add('active');
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
        cancelMomentumTracking();
    });

    slider.addEventListener('mouseleave', () => {
        isDown = false;
        slider.classList.remove('active');
    });

    slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.classList.remove('active');
        beginMomentumTracking();
    });

    slider.addEventListener('mousemove', (e) => {
        if(!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 3; //scroll-fast
        var prevScrollLeft = slider.scrollLeft;
        slider.scrollLeft = scrollLeft - walk;
        velX = slider.scrollLeft - prevScrollLeft;
    });

    slider.addEventListener('wheel', (e) => {
        cancelMomentumTracking();
    });

    // 偵測動畫
    var velX = 0;
    var momentumID;

    function beginMomentumTracking(){
        cancelMomentumTracking();
        momentumID = requestAnimationFrame(momentumLoop);
    }
    function cancelMomentumTracking(){
        cancelAnimationFrame(momentumID);
    }
    function momentumLoop(){
        slider.scrollLeft += velX;
        velX *= 0.95;
        if (Math.abs(velX) > 0.5){
            momentumID = requestAnimationFrame(momentumLoop);
        }
    }
}
export    {
    touchScroll
}
