import subprocess
import sys
import os

def convert_mp4_to_avi(name, output):
    filename, file_extension = os.path.splitext(name)
    path = "v_upload/"
    videocodec = "mpeg4"
    videotag = "xvid"
    audiocodec = "libmp3lame"
    output = "%s%s_convert%s" % (path, filename, output)
    cmd = "ffmpeg -i %s%s -vcodec %s -vtag %s -acodec %s -ac 2 -qscale 5 %s" % (path,name,videocodec,videotag,audiocodec,output)
    process = subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE)
    process.wait()
    return process.returncode

def convert_avi_to_mp4(name, output):
    filename, file_extension = os.path.splitext(name)
    path = "v_upload/"
    videocodec = "libx264"
    audiocodec = "aac"
    output = "%s%s_convert%s" % (path, filename, output)
    cmd = "ffmpeg -i %s%s -c:v %s -crf 19 -preset slow -c:a %s -strict experimental -ac 2 -b:a 192k %s" % (path,name,videocodec,audiocodec,output)
    process = subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE)
    process.wait()
    return process.returncode

def convert_mp4_to_flv(name, output):
    filename, file_extension = os.path.splitext(name)
    path = "v_upload/"
    output = "%s%s_convert%s" % (path, filename, output)
    cmd = "ffmpeg -i %s%s -ar 44100 -ab 96 -f flv %s" % (path,name,output)
    process = subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE)
    process.wait()
    return process.returncode

def main():
    if sys.argv[2] == ".mp4":
        convert_avi_to_mp4(sys.argv[1], sys.argv[2])
    elif sys.argv[2] == ".avi":
        convert_mp4_to_avi(sys.argv[1], sys.argv[2])
    elif sys.argv[2] == ".flv":
        convert_mp4_to_flv(sys.argv[1], sys.argv[2])

if __name__ == "__main__":
    main()

