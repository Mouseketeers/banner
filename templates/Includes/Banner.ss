<% if BannerImage %>
<div id="Banner">
	$BannerImage
</div>
<% else %>
<% control Level(1) %>
<% if BannerImage %>
<div id="Banner">
	$BannerImage
</div>
<% end_if %>
<% end_control %>
<% end_if %>