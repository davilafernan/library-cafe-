import tkinter as tk
from tkinter import ttk, messagebox

try:
    import mysql.connector
except ImportError:
    print("Erreur: Module mysql.connector manquant!")
    print("Installez-le avec: pip install mysql-connector-python")
    exit()

class StockApp:
    def __init__(self, root):
        self.root = root
        self.root.title("LibraryCafe - Gestion de Stock")
        self.root.geometry("800x500")
        
        # Connexion à la BD
        try:
            self.conn = mysql.connector.connect(
                host="localhost",
                user="root",
                password="",
                database="librarycafe"
            )
            self.cursor = self.conn.cursor(dictionary=True)
            print("Connexion à la BD réussie")
        except Exception as e:
            print(f"Erreur de connexion à la BD: {e}")
            messagebox.showerror("Erreur BD", str(e))
            exit()
        
        # Interface principale
        self.notebook = ttk.Notebook(root)
        self.notebook.pack(fill=tk.BOTH, expand=True, padx=10, pady=10)
        
        # Créer les onglets
        self.tab1 = tk.Frame(self.notebook)
        self.tab2 = tk.Frame(self.notebook)
        self.tab3 = tk.Frame(self.notebook)
        self.tab4 = tk.Frame(self.notebook)
        
        self.notebook.add(self.tab1, text="Produits")
        self.notebook.add(self.tab2, text="Fournisseurs")
        self.notebook.add(self.tab3, text="Commandes")
        self.notebook.add(self.tab4, text="Rapports")
        
        # Configurer les onglets
        self.setup_produits()
        self.setup_fournisseurs()
        self.setup_commandes()
        self.setup_rapports()
        
        # Bouton quitter
        tk.Button(root, text="Quitter", command=root.quit).pack(pady=10)
    
    def setup_produits(self):
        # Titre
        tk.Label(self.tab1, text="Gestion des Produits", font=("Arial", 14, "bold")).pack(pady=10)
        
        # Boutons
        btn_frame = tk.Frame(self.tab1)
        btn_frame.pack(fill=tk.X, padx=10, pady=5)
        
        tk.Button(btn_frame, text="Ajouter", command=self.ajouter_produit).pack(side=tk.LEFT, padx=5)
        tk.Button(btn_frame, text="Modifier", command=self.modifier_produit).pack(side=tk.LEFT, padx=5)
        tk.Button(btn_frame, text="Supprimer", command=self.supprimer_produit).pack(side=tk.LEFT, padx=5)
        
        # Tableau
        columns = ('id', 'nom', 'prix', 'stock', 'fournisseur')
        self.tree = ttk.Treeview(self.tab1, columns=columns, show='headings')
        
        self.tree.heading('id', text='ID')
        self.tree.heading('nom', text='Nom')
        self.tree.heading('prix', text='Prix (€)')
        self.tree.heading('stock', text='Stock')
        self.tree.heading('fournisseur', text='Fournisseur')
        
        self.tree.column('id', width=50, anchor=tk.CENTER)
        self.tree.column('nom', width=200)
        self.tree.column('prix', width=100, anchor=tk.CENTER)
        self.tree.column('stock', width=100, anchor=tk.CENTER)
        self.tree.column('fournisseur', width=150)
        
        scrollbar = ttk.Scrollbar(self.tab1, orient=tk.VERTICAL, command=self.tree.yview)
        self.tree.configure(yscroll=scrollbar.set)
        scrollbar.pack(side=tk.RIGHT, fill=tk.Y)
        
        self.tree.pack(fill=tk.BOTH, expand=True, padx=10, pady=5)
        self.tree.bind("<Double-1>", lambda e: self.modifier_produit())
        
        # Charger les produits
        self.charger_produits()
    
    def setup_fournisseurs(self):
        # Titre
        tk.Label(self.tab2, text="Gestion des Fournisseurs", font=("Arial", 14, "bold")).pack(pady=10)
        
        # Boutons
        btn_frame = tk.Frame(self.tab2)
        btn_frame.pack(fill=tk.X, padx=10, pady=5)
        
        tk.Button(btn_frame, text="Ajouter", command=self.ajouter_fournisseur).pack(side=tk.LEFT, padx=5)
        tk.Button(btn_frame, text="Modifier", command=self.modifier_fournisseur).pack(side=tk.LEFT, padx=5)
        
        # Tableau des fournisseurs
        columns = ('id', 'nom', 'contact', 'telephone')
        self.four_tree = ttk.Treeview(self.tab2, columns=columns, show='headings')
        
        self.four_tree.heading('id', text='ID')
        self.four_tree.heading('nom', text='Nom')
        self.four_tree.heading('contact', text='Contact')
        self.four_tree.heading('telephone', text='Téléphone')
        
        self.four_tree.column('id', width=50, anchor=tk.CENTER)
        self.four_tree.column('nom', width=200)
        self.four_tree.column('contact', width=200)
        self.four_tree.column('telephone', width=150)
        
        scrollbar = ttk.Scrollbar(self.tab2, orient=tk.VERTICAL, command=self.four_tree.yview)
        self.four_tree.configure(yscroll=scrollbar.set)
        scrollbar.pack(side=tk.RIGHT, fill=tk.Y)
        
        self.four_tree.pack(fill=tk.BOTH, expand=True, padx=10, pady=5)
        self.four_tree.bind("<Double-1>", lambda e: self.modifier_fournisseur())
        
        # Charger les fournisseurs
        self.charger_fournisseurs()
    
    def charger_fournisseurs(self):
        # Vider le tableau
        for i in self.four_tree.get_children():
            self.four_tree.delete(i)
        
        try:
            self.cursor.execute("SELECT * FROM fournisseurs ORDER BY nom")
            for four in self.cursor.fetchall():
                self.four_tree.insert('', 'end', values=(
                    four['id'],
                    four['nom'],
                    four['contact'] or "",
                    four['telephone'] or ""
                ))
        except Exception as e:
            messagebox.showerror("Erreur", f"Impossible de charger les fournisseurs: {str(e)}")
    
    def ajouter_fournisseur(self):
        # Fenêtre d'ajout
        win = tk.Toplevel(self.root)
        win.title("Ajouter un fournisseur")
        win.geometry("300x200")
        win.grab_set()
        
        # Champs
        tk.Label(win, text="Nom:").grid(row=0, column=0, padx=10, pady=5, sticky=tk.W)
        nom = tk.Entry(win, width=20)
        nom.grid(row=0, column=1, padx=10, pady=5)
        
        tk.Label(win, text="Contact:").grid(row=1, column=0, padx=10, pady=5, sticky=tk.W)
        contact = tk.Entry(win, width=20)
        contact.grid(row=1, column=1, padx=10, pady=5)
        
        tk.Label(win, text="Téléphone:").grid(row=2, column=0, padx=10, pady=5, sticky=tk.W)
        tel = tk.Entry(win, width=20)
        tel.grid(row=2, column=1, padx=10, pady=5)
        
        def save():
            # Récupérer les valeurs
            n = nom.get().strip()
            c = contact.get().strip()
            t = tel.get().strip()
            
            # Validation
            if not n:
                messagebox.showwarning("Attention", "Le nom est obligatoire")
                return
            
            # Insérer dans la BD
            try:
                self.cursor.execute(
                    "INSERT INTO fournisseurs (nom, contact, telephone) VALUES (%s, %s, %s)",
                    (n, c, t)
                )
                self.conn.commit()
                win.destroy()
                self.charger_fournisseurs()
                messagebox.showinfo("Succès", "Fournisseur ajouté avec succès")
            except Exception as e:
                self.conn.rollback()
                messagebox.showerror("Erreur", str(e))
        
        # Boutons
        btn_frame = tk.Frame(win)
        btn_frame.grid(row=3, column=0, columnspan=2, pady=20)
        
        tk.Button(btn_frame, text="Annuler", command=win.destroy).pack(side=tk.LEFT, padx=10)
        tk.Button(btn_frame, text="Enregistrer", command=save).pack(side=tk.LEFT, padx=10)
    
    def modifier_fournisseur(self):
        selected = self.four_tree.selection()
        if not selected:
            messagebox.showwarning("Attention", "Sélectionnez un fournisseur à modifier")
            return
            
        # Récupérer l'ID du fournisseur
        four_id = self.four_tree.item(selected[0])['values'][0]
        
        try:
            self.cursor.execute("SELECT * FROM fournisseurs WHERE id = %s", (four_id,))
            four = self.cursor.fetchone()
            
            # Fenêtre de modification
            win = tk.Toplevel(self.root)
            win.title(f"Modifier: {four['nom']}")
            win.geometry("300x200")
            win.grab_set()
            
            # Champs
            tk.Label(win, text="Nom:").grid(row=0, column=0, padx=10, pady=5, sticky=tk.W)
            nom = tk.Entry(win, width=20)
            nom.insert(0, four['nom'])
            nom.grid(row=0, column=1, padx=10, pady=5)
            
            tk.Label(win, text="Contact:").grid(row=1, column=0, padx=10, pady=5, sticky=tk.W)
            contact = tk.Entry(win, width=20)
            if four['contact']:
                contact.insert(0, four['contact'])
            contact.grid(row=1, column=1, padx=10, pady=5)
            
            tk.Label(win, text="Téléphone:").grid(row=2, column=0, padx=10, pady=5, sticky=tk.W)
            tel = tk.Entry(win, width=20)
            if four['telephone']:
                tel.insert(0, four['telephone'])
            tel.grid(row=2, column=1, padx=10, pady=5)
            
            def update():
                # Récupérer les valeurs
                n = nom.get().strip()
                c = contact.get().strip()
                t = tel.get().strip()
                
                # Validation
                if not n:
                    messagebox.showwarning("Attention", "Le nom est obligatoire")
                    return
                
                # Mettre à jour dans la BD
                try:
                    self.cursor.execute(
                        "UPDATE fournisseurs SET nom = %s, contact = %s, telephone = %s WHERE id = %s",
                        (n, c, t, four_id)
                    )
                    self.conn.commit()
                    win.destroy()
                    self.charger_fournisseurs()
                    messagebox.showinfo("Succès", "Fournisseur mis à jour avec succès")
                except Exception as e:
                    self.conn.rollback()
                    messagebox.showerror("Erreur", str(e))
            
            # Boutons
            btn_frame = tk.Frame(win)
            btn_frame.grid(row=3, column=0, columnspan=2, pady=20)
            
            tk.Button(btn_frame, text="Annuler", command=win.destroy).pack(side=tk.LEFT, padx=10)
            tk.Button(btn_frame, text="Enregistrer", command=update).pack(side=tk.LEFT, padx=10)
            
        except Exception as e:
            messagebox.showerror("Erreur", str(e))
    
    def setup_commandes(self):
        # Utilise la table commandes existante
        # Titre
        tk.Label(self.tab3, text="Gestion des Commandes", font=("Arial", 14, "bold")).pack(pady=10)
        
        # Tableau des commandes
        columns = ('id', 'date', 'client', 'total')
        self.cmd_tree = ttk.Treeview(self.tab3, columns=columns, show='headings')
        
        self.cmd_tree.heading('id', text='ID')
        self.cmd_tree.heading('date', text='Date')
        self.cmd_tree.heading('client', text='Client')
        self.cmd_tree.heading('total', text='Total (€)')
        
        self.cmd_tree.column('id', width=50, anchor=tk.CENTER)
        self.cmd_tree.column('date', width=150)
        self.cmd_tree.column('client', width=150)
        self.cmd_tree.column('total', width=100, anchor=tk.CENTER)
        
        scrollbar = ttk.Scrollbar(self.tab3, orient=tk.VERTICAL, command=self.cmd_tree.yview)
        self.cmd_tree.configure(yscroll=scrollbar.set)
        scrollbar.pack(side=tk.RIGHT, fill=tk.Y)
        
        self.cmd_tree.pack(fill=tk.BOTH, expand=True, padx=10, pady=5)
        self.cmd_tree.bind("<Double-1>", lambda e: self.voir_details_commande())
        
        # Charger les commandes
        try:
            self.cursor.execute("""
                SELECT c.id, c.date_commande, u.nom AS client_nom, c.total 
                FROM commandes c
                LEFT JOIN utilisateurs u ON c.utilisateur_id = u.id
                ORDER BY c.date_commande DESC
            """)
            
            for cmd in self.cursor.fetchall():
                date_format = cmd['date_commande'].strftime("%d/%m/%Y %H:%M")
                self.cmd_tree.insert('', 'end', values=(
                    cmd['id'], 
                    date_format, 
                    cmd['client_nom'] or "Client inconnu", 
                    f"{float(cmd['total']):.2f}"
                ))
        except Exception as e:
            messagebox.showerror("Erreur", f"Impossible de charger les commandes: {str(e)}")
    
    def setup_rapports(self):
        # Rapports simples
        # Titre
        tk.Label(self.tab4, text="Rapports", font=("Arial", 14, "bold")).pack(pady=10)
        
        # Boutons pour différents rapports
        btn_frame = tk.Frame(self.tab4)
        btn_frame.pack(pady=10)
        
        tk.Button(btn_frame, text="Produits faible stock", 
                command=lambda: self.generer_rapport("stock_faible")).pack(side=tk.LEFT, padx=5)
        
        tk.Button(btn_frame, text="Ventes du mois", 
                command=lambda: self.generer_rapport("ventes_mois")).pack(side=tk.LEFT, padx=5)
        
        # Zone d'affichage des rapports
        result_frame = tk.Frame(self.tab4)
        result_frame.pack(fill=tk.BOTH, expand=True, padx=10, pady=5)
        
        self.rapport_label = tk.Label(result_frame, text="Sélectionnez un rapport à générer", 
                                     font=("Arial", 12))
        self.rapport_label.pack(pady=10)
        
        columns = ('col1', 'col2', 'col3', 'col4')
        self.rapport_tree = ttk.Treeview(result_frame, columns=columns, show='headings')
        self.rapport_tree.pack(fill=tk.BOTH, expand=True)
        
        # Par défaut, les colonnes sont cachées
        for col in columns:
            self.rapport_tree.column(col, width=150)
    
    def generer_rapport(self, type_rapport):
        # Nettoyer le tableau de rapport
        for item in self.rapport_tree.get_children():
            self.rapport_tree.delete(item)
        
        # Configurer les colonnes selon le type de rapport
        if type_rapport == "stock_faible":
            self.rapport_label.config(text="Produits avec stock faible (< 10)")
            
            # Configurer les colonnes
            self.rapport_tree.config(columns=('id', 'nom', 'stock', 'prix'))
            self.rapport_tree.heading('id', text='ID')
            self.rapport_tree.heading('nom', text='Produit')
            self.rapport_tree.heading('stock', text='Stock')
            self.rapport_tree.heading('prix', text='Prix (€)')
            
            try:
                self.cursor.execute("""
                    SELECT id, nom, stock, prix 
                    FROM produits 
                    WHERE stock < 10 
                    ORDER BY stock
                """)
                
                for prod in self.cursor.fetchall():
                    self.rapport_tree.insert('', 'end', values=(
                        prod['id'],
                        prod['nom'],
                        prod['stock'],
                        f"{float(prod['prix']):.2f}"
                    ))
            except Exception as e:
                messagebox.showerror("Erreur", f"Erreur de génération du rapport: {str(e)}")
                
        elif type_rapport == "ventes_mois":
            self.rapport_label.config(text="Ventes du mois en cours")
            
            # Configurer les colonnes
            self.rapport_tree.config(columns=('date', 'client', 'total', 'nb_articles'))
            self.rapport_tree.heading('date', text='Date')
            self.rapport_tree.heading('client', text='Client')
            self.rapport_tree.heading('total', text='Total (€)')
            self.rapport_tree.heading('nb_articles', text='Nb Articles')
            
            try:
                self.cursor.execute("""
                    SELECT c.date_commande, u.nom AS client_nom, c.total, 
                           COUNT(ci.id) AS nb_items
                    FROM commandes c
                    LEFT JOIN utilisateurs u ON c.utilisateur_id = u.id
                    LEFT JOIN commande_item ci ON c.id = ci.commande_id
                    WHERE MONTH(c.date_commande) = MONTH(CURRENT_DATE())
                    AND YEAR(c.date_commande) = YEAR(CURRENT_DATE())
                    GROUP BY c.id
                    ORDER BY c.date_commande DESC
                """)
                
                for vente in self.cursor.fetchall():
                    date_format = vente['date_commande'].strftime("%d/%m/%Y")
                    self.rapport_tree.insert('', 'end', values=(
                        date_format,
                        vente['client_nom'] or "Client inconnu",
                        f"{float(vente['total']):.2f}",
                        vente['nb_items']
                    ))
            except Exception as e:
                messagebox.showerror("Erreur", f"Erreur de génération du rapport: {str(e)}")
    
    def charger_produits(self):
        # Vider le tableau
        for i in self.tree.get_children():
            self.tree.delete(i)
        
        try:
            self.cursor.execute("""
                SELECT p.id, p.nom, p.prix, p.stock, f.nom AS fournisseur_nom
                FROM produits p
                LEFT JOIN fournisseurs f ON p.fournisseur_id = f.id
                ORDER BY p.nom
            """)
            
            for produit in self.cursor.fetchall():
                self.tree.insert('', 'end', values=(
                    produit['id'],
                    produit['nom'],
                    f"{float(produit['prix']):.2f}",
                    produit['stock'],
                    produit['fournisseur_nom'] or "Non attribué"
                ))
        except Exception as e:
            messagebox.showerror("Erreur", f"Impossible de charger les produits: {str(e)}")
    
    def ajouter_produit(self):
        # Fenêtre d'ajout
        win = tk.Toplevel(self.root)
        win.title("Ajouter un produit")
        win.geometry("300x250")
        win.grab_set()
        
        # Champs
        tk.Label(win, text="Nom:").grid(row=0, column=0, padx=10, pady=5, sticky=tk.W)
        nom = tk.Entry(win, width=20)
        nom.grid(row=0, column=1, padx=10, pady=5)
        
        tk.Label(win, text="Prix (€):").grid(row=1, column=0, padx=10, pady=5, sticky=tk.W)
        prix = tk.Entry(win, width=10)
        prix.grid(row=1, column=1, sticky=tk.W, padx=10, pady=5)
        
        tk.Label(win, text="Stock:").grid(row=2, column=0, padx=10, pady=5, sticky=tk.W)
        stock = tk.Entry(win, width=10)
        stock.grid(row=2, column=1, sticky=tk.W, padx=10, pady=5)
        
        # Fournisseur
        tk.Label(win, text="Fournisseur:").grid(row=3, column=0, padx=10, pady=5, sticky=tk.W)
        
        # Récupérer les fournisseurs
        fournisseurs = []
        self.cursor.execute("SELECT id, nom FROM fournisseurs ORDER BY nom")
        for four in self.cursor.fetchall():
            fournisseurs.append((four['id'], four['nom']))
        
        # Ajouter l'option "Non attribué"
        fournisseurs.insert(0, (None, "Non attribué"))
        
        # Variable pour stocker le fournisseur sélectionné
        four_var = tk.StringVar(win)
        four_var.set(fournisseurs[0][1])  # Par défaut: Non attribué
        
        four_menu = ttk.Combobox(win, textvariable=four_var, values=[f[1] for f in fournisseurs], state="readonly")
        four_menu.grid(row=3, column=1, sticky=tk.W, padx=10, pady=5)
        
        def save():
            # Récupérer et valider les données
            n = nom.get().strip()
            if not n:
                messagebox.showwarning("Attention", "Le nom est obligatoire")
                return
                
            try:
                p = float(prix.get())
                if p < 0: raise ValueError()
            except:
                messagebox.showwarning("Attention", "Prix invalide")
                return
                
            try:
                s = int(stock.get()) if stock.get() else 0
                if s < 0: raise ValueError()
            except:
                messagebox.showwarning("Attention", "Stock invalide")
                return
            
            # Déterminer l'ID du fournisseur
            four_id = None
            selected_four = four_var.get()
            for f in fournisseurs:
                if f[1] == selected_four and f[1] != "Non attribué":
                    four_id = f[0]
                    break
            
            # Insérer dans la BD
            try:
                self.cursor.execute(
                    "INSERT INTO produits (nom, prix, stock, fournisseur_id) VALUES (%s, %s, %s, %s)",
                    (n, p, s, four_id)
                )
                self.conn.commit()
                win.destroy()
                self.charger_produits()
                messagebox.showinfo("Succès", "Produit ajouté avec succès")
            except Exception as e:
                self.conn.rollback()
                messagebox.showerror("Erreur", str(e))
        
        # Boutons
        btn_frame = tk.Frame(win)
        btn_frame.grid(row=4, column=0, columnspan=2, pady=20)
        
        tk.Button(btn_frame, text="Annuler", command=win.destroy).pack(side=tk.LEFT, padx=10)
        tk.Button(btn_frame, text="Enregistrer", command=save).pack(side=tk.LEFT, padx=10)
    
    def modifier_produit(self):
        selected = self.tree.selection()
        if not selected:
            messagebox.showwarning("Attention", "Sélectionnez un produit à modifier")
            return
            
        # Récupérer l'ID du produit
        prod_id = self.tree.item(selected[0])['values'][0]
        
        try:
            self.cursor.execute("""
                SELECT p.*, f.nom AS fournisseur_nom 
                FROM produits p
                LEFT JOIN fournisseurs f ON p.fournisseur_id = f.id
                WHERE p.id = %s
            """, (prod_id,))
            
            produit = self.cursor.fetchone()
            
            # Fenêtre de modification
            win = tk.Toplevel(self.root)
            win.title(f"Modifier: {produit['nom']}")
            win.geometry("300x250")
            win.grab_set()
            
            # Champs
            tk.Label(win, text="Nom:").grid(row=0, column=0, padx=10, pady=5, sticky=tk.W)
            nom = tk.Entry(win, width=20)
            nom.insert(0, produit['nom'])
            nom.grid(row=0, column=1, padx=10, pady=5)
            
            tk.Label(win, text="Prix (€):").grid(row=1, column=0, padx=10, pady=5, sticky=tk.W)
            prix = tk.Entry(win, width=10)
            prix.insert(0, produit['prix'])
            prix.grid(row=1, column=1, sticky=tk.W, padx=10, pady=5)
            
            tk.Label(win, text="Stock:").grid(row=2, column=0, padx=10, pady=5, sticky=tk.W)
            stock = tk.Entry(win, width=10)# Déterminer l'ID du fournisseur
            four_id = None
            selected_four = four_var.get()
            for f in fournisseurs:
                    if f[1] == selected_four and f[1] != "Non attribué":
                        four_id = f[0]
                        break
                
                # Mettre à jour dans la BD
            try:
                    self.cursor.execute(
                        "UPDATE produits SET nom = %s, prix = %s, stock = %s, fournisseur_id = %s WHERE id = %s",
                        (n, p, s, four_id, prod_id)
                    )
                    self.conn.commit()
                    win.destroy()
                    self.charger_produits()
                    messagebox.showinfo("Succès", "Produit mis à jour avec succès")
            except Exception as e:
                    self.conn.rollback()
                    messagebox.showerror("Erreur", str(e))
            
            # Boutons
            btn_frame = tk.Frame(win)
            btn_frame.grid(row=4, column=0, columnspan=2, pady=20)
            
            tk.Button(btn_frame, text="Annuler", command=win.destroy).pack(side=tk.LEFT, padx=10)
            tk.Button(btn_frame, text="Enregistrer", command=update).pack(side=tk.LEFT, padx=10)
            
        except Exception as e:
            messagebox.showerror("Erreur", str(e))
    
    def supprimer_produit(self):
        selected = self.tree.selection()
        if not selected:
            messagebox.showwarning("Attention", "Sélectionnez un produit à supprimer")
            return
            
        # Récupérer les infos du produit
        values = self.tree.item(selected[0])['values']
        prod_id = values[0]
        prod_nom = values[1]
        
        # Confirmer la suppression
        if not messagebox.askyesno("Confirmation", f"Voulez-vous vraiment supprimer '{prod_nom}' ?"):
            return
            
        # Supprimer le produit
        try:
            self.cursor.execute("DELETE FROM produits WHERE id = %s", (prod_id,))
            self.conn.commit()
            self.charger_produits()
            messagebox.showinfo("Succès", f"Produit '{prod_nom}' supprimé")
        except Exception as e:
            self.conn.rollback()
            messagebox.showerror("Erreur", str(e))
    
    def voir_details_commande(self):
        selected = self.cmd_tree.selection()
        if not selected:
            messagebox.showwarning("Attention", "Sélectionnez une commande pour voir les détails")
            return
            
        # Récupérer l'ID de la commande
        cmd_id = self.cmd_tree.item(selected[0])['values'][0]
        
        try:
            # Récupérer les détails de la commande
            self.cursor.execute("""
                SELECT ci.id, p.nom, ci.quantite, ci.prix, (ci.quantite * ci.prix) AS sous_total
                FROM commande_item ci
                JOIN produits p ON ci.produit_id = p.id
                WHERE ci.commande_id = %s
            """, (cmd_id,))
            
            details = self.cursor.fetchall()
            
            # Fenêtre des détails
            win = tk.Toplevel(self.root)
            win.title(f"Détails de la commande #{cmd_id}")
            win.geometry("500x300")
            win.grab_set()
            
            # Tableau des détails
            columns = ('produit', 'qte', 'prix', 'total')
            details_tree = ttk.Treeview(win, columns=columns, show='headings')
            
            details_tree.heading('produit', text='Produit')
            details_tree.heading('qte', text='Quantité')
            details_tree.heading('prix', text='Prix unitaire (€)')
            details_tree.heading('total', text='Total (€)')
            
            details_tree.column('produit', width=200)
            details_tree.column('qte', width=80, anchor=tk.CENTER)
            details_tree.column('prix', width=100, anchor=tk.CENTER)
            details_tree.column('total', width=100, anchor=tk.CENTER)
            
            scrollbar = ttk.Scrollbar(win, orient=tk.VERTICAL, command=details_tree.yview)
            details_tree.configure(yscroll=scrollbar.set)
            scrollbar.pack(side=tk.RIGHT, fill=tk.Y)
            
            details_tree.pack(fill=tk.BOTH, expand=True, padx=10, pady=10)
            
            # Remplir le tableau
            for d in details:
                details_tree.insert('', 'end', values=(
                    d['nom'],
                    d['quantite'],
                    f"{float(d['prix']):.2f}",
                    f"{float(d['sous_total']):.2f}"
                ))
            
            # Bouton fermer
            tk.Button(win, text="Fermer", command=win.destroy).pack(pady=10)
            
        except Exception as e:
            messagebox.showerror("Erreur", f"Erreur lors de l'affichage des détails: {str(e)}")
    
    def __del__(self):
        # Fermer proprement la connexion à la BD
        if hasattr(self, 'conn'):
            try:
                self.cursor.close()
                self.conn.close()
                print("Connexion BD fermée")
            except:
                pass

# Lancer l'application
if __name__ == "__main__":
    root = tk.Tk()
    app = StockApp(root)
    root.mainloop()