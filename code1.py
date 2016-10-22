import PIL	
import ImageFilter 
from PIL import Image

img = Image.open('image1.jpg')
basewidth = int(float(img.size[0]))
wpercent = (basewidth / float(img.size[0]))
hsize = int ((float(img.size[1]) * float(wpercent)))

img.save('resize_image2.jpg', format="JPEG", quality=30)

# src : 
# https://opensource.com/life/15/2/resize-images-python
# http://effbot.org/imagingbook/image.htm