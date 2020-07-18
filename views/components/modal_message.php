<?php
function show_modal_message($message)
{
	echo 
	'
	<div class="modal" tabindex="-1" role="dialog" style="display:block; position:fixed;">
	<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
	<h5 class="modal-title">Modal title</h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">&times;</span>
	</button>
	</div>
	<div class="modal-body">
	<p>'.$message.'</p>
	</div>
	</div>
	</div>
	</div>
	<script type="text/javascript">
		let close_btn = document.getElementsByClassName("close")[0];

        close_btn.addEventListener("click", () => {
            let modal = document.getElementsByClassName("modal")[0];
            modal.style.display = "none";
        });
	</script>
	';
}
?>