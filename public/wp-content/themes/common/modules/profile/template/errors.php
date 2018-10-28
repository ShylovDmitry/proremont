<?php
$param_key = isset($__data['param_key']) ? $__data['param_key'] : 'error';
$errors = isset( $_REQUEST[$param_key] ) ? explode( ',', $_REQUEST[$param_key] ) : [];
?>

<?php foreach ( $errors as $error_code ): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo pror_profile_get_error_message( $error_code ); ?>
    </div>
<?php endforeach; ?>
