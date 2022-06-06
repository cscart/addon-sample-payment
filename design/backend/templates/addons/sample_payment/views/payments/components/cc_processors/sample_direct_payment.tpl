<div class="control-group">
    <label class="control-label cm-required" for="merchant_id{$id}">{__("login")}:</label>
    <div class="controls">
        <input type="text"
               name="payment_data[processor_params][login]"
               id="merchant_id{$id}"
               value="{$processor_params.login}"
               class="input-text"
               size="60"
        />
    </div>
</div>

<div class="control-group">
    <label class="control-label cm-required" for="shared_secret{$id}">{__("shared_secret")}:</label>
    <div class="controls">
        <input type="password"
               name="payment_data[processor_params][shared_secret]"
               id="shared_secret{$id}"
               value="{$processor_params.shared_secret}"
               autocomplete="new-password"
               size="60"
        >
    </div>
</div>
