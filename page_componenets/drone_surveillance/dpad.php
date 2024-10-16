<style>
    /* Base styles for buttons */
    .control-btn {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        background-color: #F0F0F0;
        border: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: background-color 0.2s, box-shadow 0.2s;
    }

    /* Highlight style when active */
    .control-btn.highlight {
        background-color: #3276B1; /* Highlight color */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        color: white;
    }

    /* Larger bumper buttons (AWB and DISP) */
    .btn-bumper {
        width: 120px;
        height: 70px;
        border-radius: 20px;
    }

    /* Container for all buttons, centered and flexible */
    .btn-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        flex-direction: column;
        padding: 20px;
    }

    /* Row layout for directional buttons */
    .btn-row {
        display: flex;
        justify-content: center;
        margin: 10px 0;
    }

    /* Align UP with bumpers in a vertical column */
    .btn-up-container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Horizontal layout for AWB and DISP buttons */
    .btn-bumpers {
        display: flex;
        justify-content: space-between;
        width: 300px;
        margin-bottom: 10px;
    }

    /* Make the layout responsive using media queries */
    @media (max-width: 768px) {
        .btn-bumper {
            width: 100px; /* Slightly smaller bumpers on medium screens */
            height: 60px;
        }

        .control-btn {
            width: 60px; /* Smaller control buttons */
            height: 60px;
        }

        .btn-bumpers {
            width: 220px; /* Narrow the gap for smaller screens */
        }

        .btn-container {
            padding: 10px;
        }
    }

    @media (max-width: 480px) {
        .btn-bumper {
            width: 80px; /* Even smaller bumpers for mobile */
            height: 50px;
        }

        .control-btn {
            width: 50px; /* Smaller control buttons for mobile */
            height: 50px;
        }

        .btn-bumpers {
            width: 180px; /* Narrow gap for mobile screens */
        }

        .btn-container {
            padding: 5px;
        }
    }
</style>

<div class="btn-container">
    <!-- AWB and DISP BTN above UP BTN -->
    <div class="btn-up-container">
        <div class="btn-bumpers">
            <button class="control-btn btn-bumper" id="btn-awb" onclick="toggleHighlight(this)">AWB</button>
            <button class="control-btn btn-bumper" id="btn-disp" onclick="toggleHighlight(this)">DISP</button>
        </div>
        <button class="control-btn" id="btn-up" onclick="toggleHighlight(this)">UP</button>
    </div>

    <!-- LEFT AND RIGHT BTN -->
    <div class="btn-row">
        <button class="control-btn" id="btn-left" onclick="toggleHighlight(this)">LEFT</button>
        <div style="width: 120px;"></div> <!-- Spacer to create gap between LEFT and RIGHT buttons -->
        <button class="control-btn" id="btn-right" onclick="toggleHighlight(this)">RIGHT</button>
    </div>

    <!-- DOWN BTN -->
    <div class="btn-row">
        <button class="control-btn" id="btn-down" onclick="toggleHighlight(this)">DOWN</button>
    </div>
</div>


<script>
	    // Function to toggle the highlight on and off
			function toggleHighlight(button) {
        button.classList.add('highlight');  // Add highlight when clicked

        // Remove the highlight when the button is released
        document.addEventListener('mouseup', function() {
            button.classList.remove('highlight');
        }, { once: true });
    }

		// controls
function component(width, height, color, x, y) {
  this.width = width;
  this.height = height;
  this.speedX = 0;
  this.speedY = 0;
  this.x = x;
  this.y = y;
  this.update = function() {
    ctx = myGameArea.context;
    ctx.fillStyle = color;
    ctx.fillRect(this.x, this.y, this.width, this.height);
  }
  this.newPos = function() {
    this.x += this.speedX;
    this.y += this.speedY;
  }
}

function updateGameArea() {
  myGameArea.clear();
  myGamePiece.newPos();
  myGamePiece.update();
}

function moveup() {
  myGamePiece.speedY -= 1;
}

function movedown() {
  myGamePiece.speedY += 1;
}

function moveleft() {
  myGamePiece.speedX -= 1;
}

function moveright() {
  myGamePiece.speedX += 1;
}
</script>