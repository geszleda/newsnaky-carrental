import * as bootstrap from '/node_modules/bootstrap/dist/js/bootstrap.js';

console.log('hello world')

const myCarouselElement = document.querySelector('#carouselExampleCaptions')

const carousel = new bootstrap.Carousel(myCarouselElement, {
  interval: 2000,
  cycle: true,
  ride: "carousel"
})