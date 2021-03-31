var w = 400;
var h = 400;
var x;
var y;
var ballR;
var vy;
var thread;
var ballCount;
var balls;
var ballV;
var fired;
var lightPower;
var colors;
var c;
function setup() {
  createCanvas(w, h);
  background(0);//white
  reset();
}

function draw() {
  background(0, 50);
  if(vy < 2){
    if(fired === false){
      lightPower = 0;
      for(j = 0; j< thread;j++){
        var r = ballV / thread * j;
        for(i = 0;i< ballCount;i++){
          balls[i + ballCount * j] = [
            x, 
            y, 
            r * cos(TWO_PI / ballCount * i + (PI / 10 * j)), 
            r * sin(TWO_PI / ballCount * i + (PI / 10 * j))
          ];
        }
      }
      fired = true;
    }else{
      lightPower += 2;
      drawFireFlower(255 - lightPower);
      if(lightPower > 255){
        reset();
      }
    }
  }else{
    lightPower += 5;
    push();
    translate(x, y);
    drawFireBall(255 - lightPower);
    pop();
    y -= vy;
    vy -= 0.05;
  }
}

function reset(){
  x = random() * w;
  y = h;
  ballR = 10;
  vy = 5 + random() * 1.5;
  thread = 5;
  ballCount = 10;
  balls = new Array(ballCount * thread);
  ballV = 1.5;
  fired = false;
  lightPower = 0;
  colors = [color(255, 0, 0),color(0,255,0), color(0,0,255),color(255,255,255)];
  c = random(colors);
}

function drawFireBall(l){
  noStroke();
  var rate = 255 / ballR;
  for(i=0;i < ballR;i++){
    fill(rate * i, l);
    ellipse(0, 0, ballR - i + 1);
  }
}

function drawFireFlower(l){
  fill(red(c),green(c),blue(c),l);
  noStroke();
  for(i = 0;i< ballCount * thread;i++){
    ellipse(balls[i][0], balls[i][1], 3);
    balls[i] = [balls[i][0] + balls[i][2], balls[i][1] + balls[i][3], balls[i][2], balls[i][3] + 0.01];
  }
}