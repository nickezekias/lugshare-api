import face_recognition
import sys

def compare_images(image1_path, image2_path):
    # Load the images into face recognition library
    image1 = face_recognition.load_image_file(image1_path)
    image2 = face_recognition.load_image_file(image2_path)

    # Get the face encodings for the faces in the images
    encoding1 = face_recognition.face_encodings(image1)
    encoding2 = face_recognition.face_encodings(image2)

    # If either image has no face, return false
    if len(encoding1) == 0 or len(encoding2) == 0:
        return False
    
    # Compare the faces (default threshold is 0.6 for face comparison)
    results = face_recognition.compare_faces([encoding1[0]], encoding2[0])

    return results[0]  # Returns True if faces are similar, False otherwise

if __name__ == "__main__":
    # Get image paths from command line arguments
    image1_path = sys.argv[1]
    image2_path = sys.argv[2]

    # Compare the images and return result
    if compare_images(image1_path, image2_path):
        print("0")  # Similar
    else:
        print("1")  # Not Similar
