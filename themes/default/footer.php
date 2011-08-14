		<script type="text/javascript">
			$(document).ready(function() {
				if($.browser.mozilla || $.browser.opera) {
					var lnk = $('<link>');
					lnk.attr({
						href: '<?php echo $Theme->location; ?>style/style-fix.css',
						rel: 'stylesheet'
					});
					$('head').append(lnk);
				}
			});
		</script>
	</body>
</html>