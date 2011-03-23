<% if HasBanner %>
<div id="BannerContent">
	<% if BannerImage %>
	<% if BannerLink %><a href="$BannerLink.Link">$BannerImage</a>
	<% else %>
	$BannerImage
	<% end_if %>
	<% end_if %>
</div>
<% end_if %>