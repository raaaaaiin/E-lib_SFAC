<div wire:loading.delay.1000ms class="cust_overlay"
     @if(isset($loading_target) && !empty($loading_target)) wire:target="{{$loading_target}}" @endif>
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>
<style>
    .cust_overlay {
        position: fixed;
        top: 0;
        z-index: 9999;
        width: 100%;
        height: 100%;
        left: 0;
        display: none;
        background: rgba(0, 0, 0, 0.6);
    }

    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px #ddd solid;
        border-top: 4px #2e93e6 solid;
        border-radius: 50% !important;
        animation: sp-anime 0.8s infinite linear;
    }
    @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
    }
</style>
