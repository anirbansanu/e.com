<template>
    <main-template>
        <section class="about">
            <h2>About Us</h2>
            <p>
                We are a premium clothing brand dedicated to making your special
                occasions even more memorable. Our collection is designed to
                bring out the best in every celebration, whether it's a
                marriage, anniversary, or any significant event.
            </p>
            <div class="about-mission">
                <h3>Our Mission</h3>
                <p>
                    To provide top-quality clothing that combines elegance with
                    comfort, ensuring you look and feel extraordinary on your
                    special day.
                </p>
            </div>
            <div class="about-history">
                <h3>Our History</h3>
                <p>
                    Founded in 2024, our brand has quickly established itself as
                    a leader in premium clothing. Our dedication to
                    craftsmanship and attention to detail has earned us the
                    trust and admiration of our clients.
                </p>
            </div>
        </section>
    </main-template>
</template>

<script>
import MainTemplate from "../templates/MainTemplate.vue";

export default {
    components: {
        MainTemplate,
    },
};
</script>

<style scoped>
.about {
    padding: 40px;
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}
.about h2 {
    font-size: 2.5rem;
    color: #ffd700; /* Golden color */
    margin-bottom: 20px;
}
.about p {
    font-size: 1rem;
    color: #fff;
    line-height: 1.6;
}
.about-mission,
.about-history {
    margin-top: 30px;
}
.about-mission h3,
.about-history h3 {
    font-size: 2rem;
    color: #ffd700; /* Golden color */
}
</style>
