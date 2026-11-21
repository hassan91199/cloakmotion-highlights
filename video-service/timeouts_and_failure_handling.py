"""Excerpts from CloakMotion's vid-gen service (FastAPI): failing properly when something stalls or breaks."""
import subprocess
import requests

# 1. Every outbound HTTP call has a (connect, read) timeout. Without one, a hung connection ties up a worker.
REQUEST_TIMEOUT = (10, 120)
response = requests.post(url, headers=headers, json=payload, timeout=REQUEST_TIMEOUT)

# 2. Every ffmpeg/ffprobe call has a ceiling, so a wedged process cannot block a worker forever.
FFMPEG_TIMEOUT_SECONDS = 600  # one invocation, for 30-90 second videos
try:
    subprocess.run(command, stdout=subprocess.DEVNULL, stderr=subprocess.PIPE,
                   check=True, timeout=FFMPEG_TIMEOUT_SECONDS)
except subprocess.TimeoutExpired:
    logger.error(f"Timed out scaling image {input_path} after {FFMPEG_TIMEOUT_SECONDS}s")
    raise

# 3. Routes that call slow blocking code are plain `def`, not `async def`.
#    An `async def` route runs on the event loop, so a blocking call inside it freezes every other request.
#    FastAPI runs a plain `def` route in a thread pool.
# -async def render_video(request: GeneratePromptRequest):
# +def render_video(request: GeneratePromptRequest):

# 4. A failed GPT call returns None. Check that before looking inside the result
#    (the old `"error" in result` raised TypeError on None).
if not result or "error" in result:
    logger.error(f"Error generating video prompt: {result.get('message') if result else 'no response'}")
