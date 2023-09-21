import string
import pickle

import numpy as np

import nltk
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
from nltk.stem import WordNetLemmatizer

import os
os.environ['CUDA_VISIBLE_DEVICES'] = '-1'

from tensorflow import keras
from tensorflow.keras.preprocessing.sequence import pad_sequences


# Load the saved model
loaded_model = keras.models.load_model('../model/model_mirza_fin.h5')

# Initialize NLTK (download necessary resources if not already downloaded)
nltk.download('punkt')
nltk.download('stopwords')
nltk.download('omw-1.4')
nltk.download('wordnet')

# Load the tokenizer from the file
with open('../model/tokenizerNEW.pkl', 'rb') as tokenizer_file:
  word_index = pickle.load(tokenizer_file)

def remove_punctuations(text):
  punctuations_list = string.punctuation
  temp = str.maketrans('', '', punctuations_list)
  return text.translate(temp)

def remove_stopwords(text):
    stop_words = stopwords.words('english')
    imp_words = []

    # Storing the important words
    for word in str(text).split():

        if word not in stop_words:

            # Let's Lemmatize the word as well
            # before appending to the imp_words list.

            lemmatizer = WordNetLemmatizer()
            lemmatizer.lemmatize(word)

            imp_words.append(word)

    output = " ".join(imp_words)

    return output

def predict(
    sentence_to_predict,
    model,
    word_index,
    max_sequence_len = 100
  ):

  
  # Tokenize the new text using NLTK
  processed_text = sentence_to_predict #remove_stopwords(sentence_to_predict)
  new_tokens = [word_tokenize(remove_punctuations(text.lower())) for text in [processed_text]]

  # Convert NLTK tokens to token IDs using the word index
  new_sequences = [[word_index.get(word, 0) for word in tokens] for tokens in new_tokens]

  padded_new_sequence = pad_sequences(
    new_sequences,
    maxlen=max_sequence_len,
    padding='post',
    truncating='post'
  )

  # Use your trained imported model to make predictions
  prediction = model.predict(padded_new_sequence, verbose=0)[0]

  predicted_label = np.argmax(prediction)

  if predicted_label == 0:
    return "NEGATIVE"

  if predicted_label == 1:
    return "NEUTRAL"

  if predicted_label == 2:
    return "POSITIVE"

  return "POSITIVE"

import sys
sentence_to_predict = sys.argv[1]

print(predict(
    sentence_to_predict,
    loaded_model,
    word_index
  )
)