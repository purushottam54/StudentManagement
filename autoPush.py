import subprocess
import time


def upload():
    subprocess.call(["git", "add", "*"])
    subprocess.call(["git", "commit", "-m", '"code added"'])
    subprocess.call(["git", "push", "origin", "master"])
    print("\033c", end='')
    print("Code Uploded")


while True:
    upload()
    time.sleep(100) #5 min