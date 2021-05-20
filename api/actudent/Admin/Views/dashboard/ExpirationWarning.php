{if $activeLeft <= 7}
<div class="bs-callout-danger {expireNotifClass} callout-border-left mt-1 mb-1 p-1">
    <strong>{+ lang Admin.peringatan +}</strong>
    <p>{warningText} {expireDate}
    </p>
</div>
{endif}