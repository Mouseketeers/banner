<% if ManagedBanners %>
<div class="banner">
	<% control ManagedBanners %>
	<% if BannerLink %>
	<a href="$BannerLink.URLSegment">
	<% end_if %>
	<div class="banner-image">$BannerImage</div>
	<% if BannerContent %><div class="banner-content">$BannerContent</div><% end_if %>
	<% if BannerLink %></a><% end_if %>
	<% end_control %>
</div>
<% end_if %>