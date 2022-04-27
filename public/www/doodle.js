const doodleContainer = document.querySelector(".background");

const boxes = [];

// thanks, mozilla
// https://developer.mozilla.org/en-US/docs/Games/Techniques/2D_collision_detection
function checkCollision(rect1, rect2) {
    return (rect1.x < rect2.x + rect2.w &&
        rect1.x + rect1.w > rect2.x &&
        rect1.y < rect2.y + rect2.h &&
        rect1.h + rect1.y > rect2.y)
}

function collides(newBox) {
    for (const existingBox of boxes) {
        const isColliding = checkCollision(newBox, existingBox);
        if (isColliding) {
            return isColliding;
        }
    }

    return false;
}

function domRectToBox(domrect) {
    // return { x: domrect.left, y: domrect.right, w: domrect.width, h: domrect.height };
    return { x: domrect.left, y: domrect.right, w: domrect.right - domrect.left, h: domrect.bottom - domrect.top };
}

DOODLES.forEach(doodle => {
    const xRand = Math.random() * 65;
    const yRand = Math.random() * 50;

    const doodleEl = document.createElement("img");
    doodleEl.src = doodle;
    doodleContainer.append(doodleEl);

    for (let i = 0; i < 20; i++) {
        console.log(`attempting to doodle ${doodle}, try ${i}`)
        doodleEl.style.top = `${yRand}vh`;
        doodleEl.style.left = `${xRand}vw`;

        doodleEl.addEventListener("load", e=>{
            const domBox = doodleEl.getBoundingClientRect();
            console.log("dom says", domBox);
            const boundingBox = domRectToBox(domBox);
            if (!collides(boundingBox)) {
                console.log("new box", boundingBox);
                boxes.push(boundingBox);
                return;
            }
        });

    }

    doodleContainer.remove(doodleEl);
});

console.log(boxes);