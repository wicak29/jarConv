import subprocess
import sys
import os

def convert_mp4_to_avi(name, output, videocodec):
    filename, file_extension = os.path.splitext(name)
    path = "./uploads/"
    path_output = "./compressed/"
    videotag = "xvid"
    audiocodec = "libmp3lame"
    output = "%s%s_convert%s" % (path_output, filename, output)
    cmd = "ffmpeg -i %s%s -vcodec %s -vtag %s -acodec %s -ac 2 -qscale 5 %s" % (path,name,videocodec,videotag,audiocodec,output)
    process = subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE)
    process.wait()
    return process.returncode

def convert_avi_to_mp4(name, output, videocodec):
    filename, file_extension = os.path.splitext(name)
    path = "./uploads/"
    path_output = "./compressed/"
    audiocodec = "aac"
    output = "%s%s_convert%s" % (path_output, filename, output)
    cmd = "ffmpeg -i %s%s -c:v %s -crf 19 -preset slow -c:a %s -strict experimental -ac 2 -b:a 192k %s" % (path,name,videocodec,audiocodec,output)
    process = subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE)
    process.wait()
    return process.returncode

def convert_mp4_to_flv(name, output, videocodec):
    filename, file_extension = os.path.splitext(name)
    path = "./uploads/"
    path_output = "./compressed/"
    output = "%s%s_convert%s" % (path_output, filename, output)
    cmd = "ffmpeg -i %s%s -vcodec %s -ar 44100 -ab 96 -f flv %s" % (path,name,videocodec,output)
    process = subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE)
    process.wait()
    return process.returncode

def main():
    print "something here"
    if sys.argv[2] == ".mp4":
        convert_avi_to_mp4(sys.argv[1], sys.argv[2], sys.argv[3])
    elif sys.argv[2] == ".avi":
        convert_mp4_to_avi(sys.argv[1], sys.argv[2], sys.argv[3])
    elif sys.argv[2] == ".flv":
        convert_mp4_to_flv(sys.argv[1], sys.argv[2], sys.argv[3])

if __name__ == "__main__":
    main()

