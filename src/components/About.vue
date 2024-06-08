<template>
    <h1>ПРО НАС</h1>
    <div class="about-us">
        <div class="about-us-text">
            <h2>Історія</h2>
            <p>Наш книжковий магазин, "Літералія", був заснований у 2024 році з метою створити затишне місце для всіх поціновувачів книг. Засновниця магазину, Зданевич Діана, вирішила втілити свою мрію про культурний осередок у центрі міста Коломия. Від початку свого існування, "Літералія" стала місцем, де кожен читач може знайти щось для себе, від класичної літератури до сучасних бестселерів.</p>
            <h2>Що ми продаємо</h2>
            <p>Наша книгарня пропонує широкий асортимент літератури, включаючи різні жанри художніх книг, такі як любовні романи, фентезі, детективи, трилери, жахи та комікси.</p>
            <div class="contact-info">
                <h2>Контактна інформація:</h2>
                <ul>
                    <li>Адреса: вул. Симона Петлюри, 25, м. Коломия, Івано-Франківська область, Україна.</li>
                    <li>Телефон: +380 (44) 123-45-67.</li>
                    <li>Електронна пошта: literaliya@gmail.com.</li>
                    <li>Робочі години: щодня з 9:00 до 20:00.</li>
                </ul>        
            </div>
                            <div class = "about-us-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2256.901976119865!2d25.04195556036699!3d48.53372263084291!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4736d290924724a7%3A0xae9d775253d51d1b!2z0LLRg9C70LjRhtGPINCh0LjQvNC-0L3QsCDQn9C10YLQu9GO0YDQuCwgMjUsINCa0L7Qu9C-0LzQuNGPLCDQhtCy0LDQvdC-LdCk0YDQsNC90LrRltCy0YHRjNC60LAg0L7QsdC70LDRgdGC0YwsIDc4MjAw!5e0!3m2!1suk!2sua!4v1717666443761!5m2!1suk!2sua" width="600" height="450" style="border:0; margin: auto; display: block;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        </div>

        <div class="about-us-image">
            <img src="\src\assets\about_1.jpg" alt="Фото книжкового магазину">
            <img src="\src\assets\about_2.jpg" alt="Фото книжкового магазину">
        </div>

    </div>

</template>

<script>
export default {

}
</script>

<style>
.about-us {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 50px;
}

.about-us-text {
    margin: 30px;
    text-align: justify;
    border-top: 1px solid #333;
}

.about-us-text p, .contact-info ul li{
    font-size: 25px;
    line-height: 1.6;
    color: #666;
    margin-bottom: 15px;
}

.about-us-image img {
    width: 550px;
    height: auto;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 1);
    margin-bottom: 50px;
}

.about-us-text h2 {
    font-size: 28px;
    color: #333;
    margin-bottom: 10px;
}

.contact-info {
    border-top: 1px solid #333;
}

.contact-info ul li{
    margin-top:0px;
    margin-bottom: 0px;
    line-height: 1.6;
    color: #666;
}

h1{
    font-weight:initial;
}
</style>
