import tkinter as tk
from tkinter import ttk, messagebox
import mysql.connector

conn = mysql.connector.connect(
    host="localhost",
    port=3307,
    user="root",
    password="&ZR95me97",
    database="librarycafe"
)
cursor = conn.cursor()


def charger_produits():
    for row in tree.get_children():
        tree.delete(row)
    cursor.execute("SELECT id, nom, prix, stock FROM produits")
    for row in cursor.fetchall():
        tree.insert('', 'end', values=row)

def ajouter_produit():
    nom = entry_nom.get()
    stock = entry_stock.get()
    try:
        prix = float(entry_prix.get())
        stock = int(stock) if stock else 100
        cursor.execute("INSERT INTO produits (nom, prix, stock) VALUES (%s, %s, %s)", (nom, prix, stock))
        conn.commit()
        charger_produits()
        effacer_champs()
    except ValueError:
        messagebox.showerror("Erreur", "Prix et stock doivent être valides.")
    except Exception as e:
        messagebox.showerror("Erreur", str(e))

def modifier_produit():
    selected = tree.selection()
    if not selected:
        messagebox.showinfo("Info", "Sélectionnez un produit à modifier.")
        return
    try:
        produit_id = tree.item(selected[0])['values'][0]
        nom = entry_nom.get()
        prix = float(entry_prix.get())
        stock = int(entry_stock.get())
        cursor.execute("UPDATE produits SET nom=%s, prix=%s, stock=%s WHERE id=%s", (nom, prix, stock, produit_id))
        conn.commit()
        charger_produits()
        effacer_champs()
    except Exception as e:
        messagebox.showerror("Erreur", str(e))

def supprimer_produit():
    selected = tree.selection()
    if not selected:
        return
    for item in selected:
        produit_id = tree.item(item)['values'][0]
        cursor.execute("DELETE FROM produits WHERE id = %s", (produit_id,))
    conn.commit()
    charger_produits()

def remplir_champs(event):
    selected = tree.selection()
    if not selected:
        return
    values = tree.item(selected[0])['values']
    entry_nom.delete(0, tk.END)
    entry_nom.insert(0, values[1])
    entry_prix.delete(0, tk.END)
    entry_prix.insert(0, values[2])
    entry_stock.delete(0, tk.END)
    entry_stock.insert(0, values[3])

def effacer_champs():
    entry_nom.delete(0, tk.END)
    entry_prix.delete(0, tk.END)
    entry_stock.delete(0, tk.END)

# Interface graphique
root = tk.Tk()
root.title("Gestion des Produits - LibraryCafe")
root.geometry("700x550")
root.configure(bg="#f4f4f4")

frame = tk.Frame(root, bg="#f4f4f4")
frame.pack(pady=20)

tk.Label(frame, text="Nom du produit:", bg="#f4f4f4").grid(row=0, column=0, padx=5, pady=5, sticky="e")
entry_nom = tk.Entry(frame, width=30)
entry_nom.grid(row=0, column=1, padx=5)

tk.Label(frame, text="Prix (€):", bg="#f4f4f4").grid(row=1, column=0, padx=5, pady=5, sticky="e")
entry_prix = tk.Entry(frame, width=30)
entry_prix.grid(row=1, column=1, padx=5)

tk.Label(frame, text="Stock:", bg="#f4f4f4").grid(row=2, column=0, padx=5, pady=5, sticky="e")
entry_stock = tk.Entry(frame, width=30)
entry_stock.grid(row=2, column=1, padx=5)

btn_frame = tk.Frame(root, bg="#f4f4f4")
btn_frame.pack(pady=10)

tk.Button(btn_frame, text="Ajouter", command=ajouter_produit, width=15, bg="#4CAF50", fg="white").grid(row=0, column=0, padx=10)
tk.Button(btn_frame, text="Modifier", command=modifier_produit, width=15, bg="#2196F3", fg="white").grid(row=0, column=1, padx=10)
tk.Button(btn_frame, text="Supprimer", command=supprimer_produit, width=15, bg="#f44336", fg="white").grid(row=0, column=2, padx=10)
tk.Button(btn_frame, text="Effacer", command=effacer_champs, width=15, bg="#9E9E9E", fg="white").grid(row=0, column=3, padx=10)

tree = ttk.Treeview(root, columns=("ID", "Nom", "Prix", "Stock"), show="headings")
tree.heading("ID", text="ID")
tree.heading("Nom", text="Nom")
tree.heading("Prix", text="Prix (€)")
tree.heading("Stock", text="Stock")
tree.column("ID", width=50)
tree.column("Nom", width=200)
tree.column("Prix", width=100)
tree.column("Stock", width=100)
tree.pack(fill=tk.BOTH, expand=True, padx=20, pady=10)
tree.bind("<<TreeviewSelect>>", remplir_champs)

charger_produits()

root.mainloop()
cursor.close()
conn.close()

# Barre de menu
menu_bar = tk.Menu(root)
root.config(menu=menu_bar)

# Menu "Gestion"
gestion_menu = tk.Menu(menu_bar, tearoff=0)
menu_bar.add_cascade(label="Menu", menu=gestion_menu)
gestion_menu.add_command(label="Fournisseurs", command=lambda: ouvrir_fournisseurs())
gestion_menu.add_command(label="Ventes", command=lambda: ouvrir_ventes())
gestion_menu.add_command(label="Rapports", command=lambda: ouvrir_rapports())
gestion_menu.add_separator()
gestion_menu.add_command(label="Quitter", command=root.quit)


def ouvrir_fournisseurs():
    fenetre = tk.Toplevel(root)
    fenetre.title("Gestion des Fournisseurs")
    fenetre.geometry("400x300")
    tk.Label(fenetre, text="Interface de gestion des fournisseurs à venir").pack(pady=20)

def ouvrir_ventes():
    fenetre = tk.Toplevel(root)
    fenetre.title("Enregistrer une Vente")
    fenetre.geometry("400x300")
    tk.Label(fenetre, text="Interface d'enregistrement des ventes à venir").pack(pady=20)

def ouvrir_rapports():
    fenetre = tk.Toplevel(root)
    fenetre.title("Rapports")
    fenetre.geometry("400x300")
    tk.Label(fenetre, text="Interface de génération des rapports à venir").pack(pady=20)
