<% if HasBanner %>
<div id="PageBannerWrap" class="wrap">
	<div id="PageBannerContainer" class="container typography"<% if BannerImage %> style="background-image:url($BannerImage.Filename)"<% end_if %>>
		<div id="PageBannerContent">
			<% if BannerContent %>$BannerContent<% end_if %>
			<% if BannerLink %><p><a href="$BannerLink.URLSegment" class="readMore"><% if BannerLinkTitle %>$BannerLinkTitle<% else %>Læs mere<% end_if %></a></p><% end_if %>
		</div>
	</div>
</div>
<% end_if %>