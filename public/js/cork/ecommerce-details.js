

// Color Swatch

var colors = ['#4361ee', '#009688', '#008eff', '#7d30cb', '#f8538d', '#e2a03f', '#1b2e4b']

document.querySelectorAll('.color-swatch input[name="flexRadioDefault"]').forEach((element, index, array) => {
    element.style.backgroundColor = colors[index]
})
