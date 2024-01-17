        <script type="text/javascript">
var base_url = '<?= base_url() ?>',
    csrf_key = '<?= $csrf_string ?>',
    firebase = '<?= $_CONFIG['firebase'] ?>',
    ajax_message = {
        "loading": {"select": "<option selected disabled>Loading...</option>"},
        "error": {"select": "<option selected disabled>There is an error.</option>"}
    },
    error_result = '<?= sessResult(false,'There is an error!') ?>',
    require_location_access = '<?= $_USER['require']['location'] ?>';
function copy_to_clipboard(element) {
    var copyText = document.getElementById(element);
    copyText.select();
    document.execCommand("copy");
}
        </script>
