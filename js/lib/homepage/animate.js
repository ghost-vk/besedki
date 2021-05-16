import scrollTriggers from 'scroll-triggers';

export const animateHome = () => {
    scrollTriggers([
        {
            el: document.getElementById('lookAtAll'),
            once: true,
            inView: (el) => el.classList.add('visible', 'animate__animated', 'animate__fadeInDown')
        },
        {
            el: document.getElementById('lookAllReviews'),
            once: true,
            inView: (el) => el.classList.add('visible', 'animate__animated', 'animate__fadeInDown')
        },
        {
            el: document.querySelectorAll('.homeFeatures .homeFeatures__item'),
            once: true,
            inView: (el) => el.classList.add('visible', 'animate__animated', 'animate__fadeIn')
        },
        {
            el: document.querySelectorAll('.titleAnimated'),
            once: true,
            inView: (el) => {
                let attr, animationClass;
                attr = el.getAttribute('data-animation');
                animationClass = (attr === "left") ? "animate__fadeInLeft" : "animate__fadeInRight";
                el.classList.add('active', 'animate__animated', animationClass);
            }
        },
        {
            el: document.querySelectorAll('.homeQuestion .homeQuestion__item'),
            once: true,
            inView: (el) => el.classList.add('visible', 'animate__animated', 'animate__slideInLeft')
        },
        {
            el: document.querySelectorAll('.homeAtmosphere .homeAtmosphere__img'),
            once: true,
            inView: (el) => el.classList.add('visible', 'animate__animated', 'animate__fadeIn')
        }
    ]);
}