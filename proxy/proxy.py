import socket
import threading
import mysql.connector

# Ma'lumotlar bazasi ulanishi
db_config = {
    "host": "localhost",
    "user": "root",
    "password": "",
    "database": "phd"
}

# Server sozlamalari
PROXY_HOST = "0.0.0.0"
PROXY_PORT = 8080
BUFFER_SIZE = 4096

def get_user_role(username):
    """Foydalanuvchi rolini bazadan olish."""
    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()
        cursor.execute("SELECT role FROM users WHERE username = %s", (username,))
        result = cursor.fetchone()
        conn.close()
        return result[0] if result else None
    except Exception as e:
        print(f"DB xatosi: {e}")
        return None

def get_file_role(file_name):
    """Faylga tegishli rolni bazadan olish."""
    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()
        cursor.execute("SELECT role FROM data WHERE file_name = %s", (file_name,))
        result = cursor.fetchone()
        conn.close()
        return result[0] if result else None
    except Exception as e:
        print(f"DB xatosi: {e}")
        return None

def handle_client(client_socket):
    """Mijozdan kelgan so‘rovni qayta ishlash va tekshirish."""
    try:
        request = client_socket.recv(BUFFER_SIZE).decode()
        
        # So‘rov tarkibini analiz qilish
        lines = request.split("\n")
        first_line = lines[0].split(" ")

        if len(first_line) < 2:
            client_socket.close()
            return

        method, url = first_line[0], first_line[1]
        print(f"So‘rov: {method} {url}")

        # Foydalanuvchi nomini URL dan olish (bu qism loyihaga bog‘liq)
        username = "test_user"  # Bu qism autentifikatsiyaga bog‘liq bo‘ladi

        user_role = get_user_role(username)
        file_role = get_file_role(url.split("/")[-1])

        if file_role is not None and user_role is not None:
            if user_role >= file_role:
                print(f"✅ {username} ({user_role}) faylni ({file_role}) olishiga ruxsat!")
            else:
                print(f"❌ {username} ({user_role}) faylni ({file_role}) olishga ruxsati yo‘q!")
                client_socket.send(b"HTTP/1.1 403 Forbidden\r\n\r\nAccess Denied!")
                client_socket.close()
                return

        # Asosiy serverga so‘rov yuborish
        remote_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        remote_socket.connect(("example.com", 80))  # Asl serverga ulanish
        remote_socket.send(request.encode())

        while True:
            response = remote_socket.recv(BUFFER_SIZE)
            if len(response) == 0:
                break
            client_socket.send(response)

        remote_socket.close()
        client_socket.close()

    except Exception as e:
        print(f"Xatolik: {e}")
        client_socket.close()

def start_proxy():
    """Proksi serverni ishga tushirish."""
    server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    server.bind((PROXY_HOST, PROXY_PORT))
    server.listen(5)
    print(f"Proksi server {PROXY_HOST}:{PROXY_PORT} da ishga tushdi...")

    while True:
        client_socket, addr = server.accept()
        print(f"Yangi ulanish: {addr}")
        client_handler = threading.Thread(target=handle_client, args=(client_socket,))
        client_handler.start()

if __name__ == "__main__":
    start_proxy()
