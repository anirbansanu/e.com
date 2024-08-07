<template>
    <div class="rating">
        <span
            v-for="star in maxStars"
            :key="star"
            class="star"
            :class="{ filled: star <= rating }"
            @click="setRating(star)"
        >
            ★
        </span>
    </div>
</template>

<script>
export default {
    props: {
        rating: {
            type: Number,
            default: 0,
        },
        maxStars: {
            type: Number,
            default: 5,
        },
    },
    methods: {
        setRating(star) {
            this.$emit("update:rating", star);
        },
    },
};
</script>

<style scoped>
.rating {
    display: flex;
}
.star {
    font-size: 1.5rem;
    color: #ffd700; /* Golden color */
    cursor: pointer;
}
.star.filled {
    color: #ffc107; /* Darker golden color for filled stars */
}
</style>
