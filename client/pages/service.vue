<template>
<div>
    <!-- /Clients -->
    <!-- FAQ -->
    <section id="features" class="section is-medium is-skewed-sm">
                <div class="container is-reverse-skewed-sm">
                    <!-- Title -->
                    <div class="section-title-wrapper has-text-centered">
                        <div class="clean-bg-symbol"><i class="fa fa-gg"></i></div>
                        <div>
                            <h2 class="clean-section-title"></h2>
                            <h3 class="subtitle is-5 pt-10 pb-10">
                                Our Service
                            </h3>
                        </div>
                    </div>

                    <div class="content-wrapper">
                        <!-- Navigation pills -->
                        <div class="columns is-vcentered">
                            <div class="column">
                                <div class="navigation-tabs outlined-pills animated-tabs mb-40">
                                    <div class="tabs is-centered">
                                        <ul>
                                            <li class="tab-link" :class="{'is-active' : tabname == 'web'}" @click.prevent="tabname = 'web'" data-tab="new-deals" ><a>Web Developing &amp; Design</a></li>
                                            <li class="tab-link" :class="{'is-active' : tabname == 'security'}" data-tab="reporting" @click.prevent="tabname = 'security'"><a>Securing Your Application</a></li>
                                            <li class="tab-link" :class="{'is-active' : tabname == 'teaching'}" data-tab="teaching" @click.prevent="tabname= 'teaching'"><a>Teaching</a></li>
                                        </ul>
                                    </div>
                                    <!-- Pill content -->
                                    <div v-if="tabname == 'web'" id="new-deals" class="navtab-content pt-20 pb-20 is-active">
                                        <div class="columns is-vcentered">
                                            <div class="column is-6">
                                                <figure class="image">
                                                    <img src="assets/images/illustrations/mockups/landing1/opportunities.png" alt="">
                                                </figure>
                                            </div>
                                            <div class="column is-6">
                                                <div class="content padding-20">
                                                    <h2 class="feature-headline is-clean">
                                                    Web Developing &amp; Design
                                                </h2>

                                                    <p class="no-margin-bottom pt-5 pb-5">
                                                        What We Do Technologies We Use
                                                    </p>
                                                    <p class="no-margin-bottom pt-5 pb-5">
                                                    Your Idea is worthy and the world has to see it, Don't bother yourself with the process !, we will show your creative idea to the world at Its best shape ,sec theater can provide you with the perfect website relating to your business ,custom or normal design to shed the light on your company among compititors </p>
                                                    <ul>
                                                        <li><p class="no-padding mt-10">
                                                        Social Media Integartion ( Such as Login with facebok or google )</p>
                                                        </li>
                                                        <li><p class="no-padding mt-10">API ( Such as this website )</p></li>
                                                        <li><p class="no-padding mt-10">Reservasion websites </p></li>
                                                        <li><p class="no-padding mt-10">Social network ( Such as facebook )</p></li>
                                                        <li><p class="no-padding mt-10">E-commerce ( Online shop cart )</p></li>
                                                    </ul>
                                                    <ul>
                                                        <li><p class="no-padding mt-10">Laravel</p></li>
                                                        <li><p class="no-padding mt-10">WordPress</p></li>
                                                        <li><p class="no-padding mt-10">NodeJS </p></li>
                                                        <li><p class="no-padding mt-10">Bulma/Bootstrap/Materialize</p></li>
                                                        <li><p class="no-padding mt-10">AngularJS/ReactJS/VueJS</p></li>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pill content -->
                                    <div v-else-if="tabname =='security'" id="reporting" class="navtab-content pt-20 pb-20">
                                        <div class="columns is-vcentered">
                                            <div class="column is-6">
                                                <figure class="image">
                                                    <img src="assets/images/illustrations/mockups/landing1/reports.png" alt="">
                                                </figure>
                                            </div>
                                            <div class="column is-6">
                                                <div class="content padding-20">
                                                    <h2 class="feature-headline is-clean">
                                                        Securing Your Application
                                                    </h2>

                                                    <p class="no-margin-bottom pt-5 pb-5">Security reprensents to our human being almost everything, we are always looking for securing ourselves. Building solid houses and doors, cars, putting our money in banks, etc.
                                                    </p>
                                                    <p class="no-margin-bottom pt-5 pb-5">
                                                        But what about our digital informations?! Who's responsible for securing them for us. So, henceforth, SecTheater is taking the responsibility of securing your digital information. </p>
                                                        <p class="no-margin-bottom pt-5 pb-5">
                                                        We are giving you the chance to have a secured website using the latest techniques in an easy process. </p>
                                                        <p class="no-margin-bottom pt-5 pb-5">
                                                        But what in case you already have a website. This will not represent any problem at all.</p>
                                                        <p class="no-margin-bottom pt-5 pb-5">
                                                    We can assure you securing your website aswell.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Pill content -->
                                    <div v-else-if="tabname == 'teaching'" id="teaching" class="navtab-content pt-20 pb-20">
                                        <div class="columns is-vcentered">
                                            <div class="column is-6">
                                                <figure class="image">
                                                    <img src="assets/images/illustrations/mockups/landing1/invoices.png" alt="">
                                                </figure>
                                            </div>
                                            <div class="column is-6">
                                                <div class="content padding-20">
                                                    <h2 class="feature-headline is-clean">
                                                        Teaching
                                                    </h2>
                                                    <p class="no-margin-bottom pt-5 pb-5"> We are just there for you with an exculsive content to deliever you to your own seized opportunity. Start learning by our professionals and get in touch with the market.</p> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Navigation pills -->
                    </div>
                </div>
            </section>
    <!-- /FAQ -->
    <!-- Newsletter section -->
</div>
</template>
<script>
    export default {
        data(){
            return {
                tabname : 'web'
            }
        }
    };
</script>