<head>
  <title>Tài khoản bị khoá</title>
</head>
<style>
    html,
body {
  height: 100%;
  width: 100%;
  margin: 0;
}
body {
  background-color: #2c5a57;
  background-image: linear-gradient(#101922, #275451);
  background-size: 100%;
  text-align: center;
  line-height: 1.45;
}

p {
  text-transform: uppercase;
  font-family: 'Montserrat', sans-serif;
  font-weight: 600;
  font-size: 26px;
  letter-spacing: 4px;
  color: white;
  margin: 3em 0 1em;
  opacity: 0;
  animation: fadedown .5s ease-in-out;
  animation-delay: 1s;
  animation-fill-mode: forwards;
}

h3 {
  color: #ecdb35;
  font-family: 'squada one';
  text-transform: uppercase;
  font-size: 50px;
  text-shadow: 0 3px red;
  margin: 0;
  transform: scale(0);
  animation: zoomin 1s ease-in-out;
  animation-delay: 2s;
  animation-fill-mode: forwards;
}

h1 span {
  display: inline-block;
}

h1 + p {
  font-size: 20px;
  letter-spacing: 2px;
  max-width: 50%;
  margin-left: auto;
  margin-right: auto;
  animation-delay: 3.5s;
}

@keyframes zoomin {
  0% {
    transform: scale(0);
  }
  90% {
    transform: scale(1.1);
  }
  95% {
    transform: scale(1.07);
  }
  100% {
    transform: scale(1);
  }
}

@keyframes fadedown {
  0% {
    opacity: 0;
    transform: translate3d(0,-10px,0);
  }
  90% {
    transform: translate3d(0,1px,0);
  }
  100% {
    opacity: 1;
    transform: translate3d(0,0,0);
  }
}
</style>
<p><?=__('Welcome to 403:');?></p>
<h3><?=__('TÀI KHOẢN CỦA BẠN ĐÃ BỊ TẠM KHOÁ');?></h3>
<?=$CMSNT->site('html_banned');?>

<script>
    function norm(value, min, max) {
  return (value - min) / (max - min);
}

function lerp(norm, min, max) {
  return (max - min) * norm + min;
}

function map(value, sourceMin, sourceMax, destMin, destMax) {
  return lerp(norm(value, sourceMin, sourceMax), destMin, destMax);
}

function map2(value, sourceMin, sourceMax, destMin, destMax, percent) {
  return percent <= 0.5
    ? map(value, sourceMin, sourceMax, destMin, destMax)
    : map(value, sourceMin, sourceMax, destMax, destMin);
}

function fisheye(el) {
  let text = el.innerText.trim(),
    numberOfChars = text.length;

  el.innerHTML =
    "<span>" +
    text
      .split("")
      .map(c => {
        return c === " " ? "&nbsp;" : c;
      })
      .join("</span><span>") +
    "</span>";

  el.querySelectorAll("span").forEach((c, i) => {
    const skew = map(i, 0, numberOfChars - 1, -15, 15),
      scale = map2(i, 0, numberOfChars - 1, 1, 3, i / numberOfChars),
      letterSpace = map2(i, 0, numberOfChars - 1, 5, 20, i / numberOfChars);

    c.style.transform = "skew(" + skew + "deg) scale(1, " + scale + ")";
    c.style.letterSpacing = letterSpace + "px";
  });
}

fisheye(document.querySelector("h1"));

</script>