Some videos are compressed to reduce the data consumption and playback buffering for users instead of had to stream at lossless / higher bitrates.

The video is compressed in H.264 Main Profile MP4 (uses NVENC H.264 codec) and WebM VP9 (uses VP9 video codec) in 1.5Mbps at 24 FPS, 1920x1080.

Original videos are located in the "Archive" folder.

Some videos are compressed separately for video quality controls for better UX (using WebM VP9):
1920x1080 30 FPS = 4.0 Mbps [ends with "fhd" (Full HD) file name]
1280x720  30 FPS = 2.5 Mbps [ends with "hd" (High Definition) file name]
854x480   30 FPS = 1.5 Mbps [ends with "sd" (Standard Definition) file name]
640x360   30 FPS = 0.5 Mbps [ends with "ds" (Data Saver) file name]


#####   MP4 to m3u8 for HLS/Plyr   #####

Compress/Export a video in separated resolutions (1080p, 720p, 480p and 360p) in MP4 based on the corresponding bit rates:

2160p: 16.0 Mbps
1440p:  8.0 Mbps
1080p:  4.0 Mbps
720p :  2.5 Mbps
480p :  1.5 Mbps
360p :  0.5 Mbps

Video codec used to export/compress a video must be H.264 with AAC audio codec. Then convert the compressed video to m3u8 for HLS.

In simple terms;
1. Made a promotional video in high quality.
2. Compress 1 original MP4 to several MP4 in various resolutions.
3. Convert the compressed video to m3u8
4. Create a main.m3u8 (refer to video-sample)