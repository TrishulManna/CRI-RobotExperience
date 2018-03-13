function isInArray(value, array) {
    return array.indexOf(value) > -1;
}

function hasMovement(value) {
    return value > 0.2 || value < -0.2;
}