import sys
import json

def get_action_from_json(json_str):
    # Replace * with "
    json_str = json_str.replace('*', '"')
    data = json.loads(json_str)
    return data.get('action')

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python test.py '<json_string>'")
    else:
        json_str = sys.argv[1]
        action = get_action_from_json(json_str)
        print(action)
