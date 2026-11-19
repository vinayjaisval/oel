@php($label = $label ?? 'details')
<div class="ud-empty-state">
    <h3>Details coming soon</h3>
    <p>Ask our counsellors about {{ $label }} for this university.</p>
    <button type="button" class="ud-btn-primary" onclick="openWizard()">Talk to a counsellor</button>
</div>
