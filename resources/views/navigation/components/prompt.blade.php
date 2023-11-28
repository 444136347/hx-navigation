<div class="prompt-dialog" id="prompt-dialog" >
    <div class="prompt-content">
        <p>请点击右上角</p>
        <p>选择“在浏览器中打开”</p>
        <p>注：该链接在微信内无法使用</p>
    </div>
    <img class="prompt" src="{{admin_asset('vendor/web-stack/img/wx/prompt.png')}}">

</div>

<style>
    .prompt-dialog {
        display:none;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, .8);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 99999;
    }
    .prompt-dialog img.prompt {
        width: 60px;
        height: 60px;
        position: absolute;
        top: 5%;
        right: 20px;
    }
    .prompt-dialog .prompt-content {
        color: #f8f8f2;
        width: calc(100% - 100px);
        height: 120px;
        position: absolute;
        text-align: center;
        font-size: 14px;
        font-weight: 300;
        top: 20%;
        left: 50%;
        transform: translate(-50%, -50%);
        overflow: scroll;
    }
    .prompt-dialog .prompt-content p {
        color: #f8f8f2;
    }
</style>
