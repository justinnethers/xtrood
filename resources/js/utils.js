export const hasBeenUsed = (roll) => {
    return roll.weight < 1000 || roll.usages.length
}
