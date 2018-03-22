# MBWP Banner

This WordPress plugin creates 3 extra places for ads, one on top of the website and two on each side.

###Cache
For multiple banners there are 2 modes, with cache on and off. With a cache of WordPress will load one banner on each refresh based on priority, higher priority number higher chances on the ad being shown. With cache on, WordPress will load return all banners, banners will be hidden and javascript will show banner base on priority. WordPress cache plugin caches all html, in order so that only one banner is shown up cache options should be enabled.

###Adblock
On iframe's there is Adblock check, if the iframe is being blocked by ad blockers, the backup image will be shown linked to the ad from ad link field. Javascript checks the opacity of body element inside iframe and if opacity is o, image is shown instead of iframe.With the option "show image only" enabled WordPress will not load iframe, only image from the image field will be shown. If the fields are empty default image will be shown.

###Boxed Layout
Boxed layout option is self explanatory, it as a wrap around the website with max-width of the width field. If the banner option is enabled, the size will only affect banners, as some WordPress themes or plugin may have their own version implemented