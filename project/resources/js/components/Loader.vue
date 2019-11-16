<template>
    <div>
        <div class="loader animated" :style="{height: size*2 + 'px'}" v-if="showLoader"> 
            <svg class="circular" :style="{width: size, height: size}" viewBox="35 35 60 60">
                <circle class="path" cx="60" cy="60" r="30" fill="none"  stroke-width="2" stroke-miterlimit="10"></circle>
            </svg>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'loader',
        props: {
            showLoader: {
                required: true
            },
            size: {
                default() {
                    return 50;
                }
            }, 
        }
    }
</script>

<style scoped>
    .loader {
        display: block;
        width: 100%;
        position: relative;
    }

    .loader svg {
        margin: auto;
    }

    .circular {
        width: 50px;
        height: 50px;
        margin: auto;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        transform-origin: center center;
        animation: rotate 2s linear infinite;
        border-radius: 50%;
    }

    .path {
        stroke-dasharray: 1, 200;
        stroke-dashoffset: 0;
        animation: dash 1.5s ease-in-out infinite, color 6s ease-in-out infinite;
        stroke-linecap: round;
    }

    @keyframes rotate {
        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes dash {
        0% {
            stroke-dasharray: 1, 200;
            stroke-dashoffset: 0;
        }
        50% {
            stroke-dasharray: 89, 200;
            stroke-dashoffset: -35px;
        }
        100% {
            stroke-dasharray: 89, 200;
            stroke-dashoffset: -124px;
        }
    }

    @keyframes color {
        100%,
        0% {
            stroke: #d62d20;
        }
        40% {
            stroke: #6E4397;
        }
        66% {
            stroke: #2f3d4a;
        }
        80%,
        90% {
            stroke: #ffa700;
        }
    }
</style>
