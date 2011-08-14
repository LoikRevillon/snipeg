		<script type="text/javascript">
			$(document).ready(function() {
				if($.browser.mozilla || $.browser.opera) {
					var lnk = $('<link>');
					lnk.attr({
						rel: 'stylesheet',
						href: '<?php echo $Theme->location; ?>style/style-fix.css'
					});
					$('head').append(lnk);
				}
			});
		</script>
	</body>
</html>