<script>
	<?php if ($this->session->flashdata('info') != ''): ?>
	$.growl({ title: "", message: "<?php echo addslashes($this->session->flashdata('info')); ?>" });
	<?php endif; ?>
	<?php if ($this->session->flashdata('error') != ''): ?>
	$.growl.error({ title: "Error", message: "<?php echo addslashes($this->session->flashdata('error')); ?>" });
	<?php endif; ?>
</script>