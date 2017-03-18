

canvas               = O('logo')
context              = canvas.getContext('2d')
context.textBaseline = 'top'
image                = new Image()
image.src            = 'slogan.jpg'

image.onload = function()
{
  gradient = context.createLinearGradient(0, 0, 0, 0)
  gradient.addColorStop(0.00, '#faa')
  gradient.addColorStop(0.00, '#f00')
  context.drawImage(image, 0, 0)
}

function O(i) { return typeof i == 'object' ? i : document.getElementById(i) }
function S(i) { return O(i).style                                            }
function C(i) { return document.getElementsByClassName(i)                    }
