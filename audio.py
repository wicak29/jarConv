# Bit-rate is optional
# Set default bit-rate to 128k
"""
#  PHP commands :
#  exec("python audio.py -f ".$filename." -c ".$convertto." -b ".$bitrate)
"""

from pydub import AudioSegment
from argparse import ArgumentParser

ap = ArgumentParser()
ap.add_argument("-f", "--filename", required=True)
ap.add_argument("-c", "--convertto", required=True)
ap.add_argument("-b", "--bitrate", required=True)
ap.add_argument("-e", "--codec",required=False)
args = vars(ap.parse_args())

file_name = args["filename"]
convert_to = args["convertto"]
bit_rate = args["bitrate"]
codec = args["codec"]

# AudioSegment.from_file('./uploads/Audio/dolphin.wav').export('./compressed/Audio/dolphin.mp3', format='mp3', bitrate=bit_rate)
AudioSegment.from_file('./uploads/Audio/'+file_name).export('./compressed/Audio/'+file_name.split('.')[0]+'.'+convert_to, format=convert_to, bitrate=bit_rate, codec=codec)
